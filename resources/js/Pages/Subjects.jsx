import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

export default function Subjects() {
    const [subjects, setSubjects] = useState([]);
    const [name, setName] = useState('');
    const [code, setCode] = useState('');
    const role = localStorage.getItem('role');
    const token = localStorage.getItem('token');
    const navigate = useNavigate();

    useEffect(() => {
        fetchSubjects();
    }, []);

    const fetchSubjects = async () => {
        try {
            const res = await axios.get('http://127.0.0.1:8000/api/subjects', {
                headers: { Authorization: `Bearer ${token}` }
            });
            setSubjects(res.data.data);
        } catch (err) {
            console.error(err);
        }
    };

    const handleAdd = async (e) => {
        e.preventDefault();
        try {
            await axios.post('http://127.0.0.1:8000/api/subjects', { name, code }, {
                headers: { Authorization: `Bearer ${token}` }
            });
            setName(''); 
            setCode('');
            alert("Matière ajoutée !");
            fetchSubjects(); // Refresh list
        } catch (err) {
            alert('Erreur lors de l\'ajout (Code peut-être déjà utilisé)');
        }
    };

    const handleDelete = async (id) => {
        if(!confirm('Supprimer cette matière ?')) return;
        try {
            await axios.delete(`http://127.0.0.1:8000/api/subjects/${id}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            fetchSubjects();
        } catch (err) {
            alert('Erreur: Accès refusé');
        }
    };

    return (
        <div className="container mt-5">
            <h2>📚 Gestion des Matières</h2>
            <button onClick={() => navigate('/dashboard')} className="btn btn-secondary mb-4">← Retour</button>

            {role === 'admin' && (
                <div className="card mb-4 p-4 shadow-sm border-success">
                    <h5 className="text-success">Ajouter une matière</h5>
                    <form onSubmit={handleAdd} className="row g-3">
                        <div className="col-md-5">
                            <input className="form-control" placeholder="Nom (ex: Algorithmique)" value={name} onChange={e => setName(e.target.value)} required />
                        </div>
                        <div className="col-md-5">
                            <input className="form-control" placeholder="Code (ex: ALG1)" value={code} onChange={e => setCode(e.target.value)} required />
                        </div>
                        <div className="col-md-2">
                            <button className="btn btn-success w-100">Ajouter</button>
                        </div>
                    </form>
                </div>
            )}

            <table className="table table-striped table-bordered">
                <thead className="table-dark">
                    <tr>
                        <th>Code</th>
                        <th>Nom de la matière</th>
                        {role === 'admin' && <th>Action</th>}
                    </tr>
                </thead>
                <tbody>
                    {subjects.length > 0 ? subjects.map(sub => (
                        <tr key={sub.id}>
                            <td><strong>{sub.code}</strong></td>
                            <td>{sub.name}</td>
                            {role === 'admin' && (
                                <td>
                                    <button onClick={() => handleDelete(sub.id)} className="btn btn-sm btn-danger">Supprimer</button>
                                </td>
                            )}
                        </tr>
                    )) : <tr><td colSpan="3" className="text-center">Aucune matière trouvée</td></tr>}
                </tbody>
            </table>
        </div>
    );
}