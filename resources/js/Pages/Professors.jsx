import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

export default function Professors() {
    const [profs, setProfs] = useState([]);
    const [form, setForm] = useState({ first_name: '', last_name: '', email: '', specialty: '' });
    const role = localStorage.getItem('role');
    const token = localStorage.getItem('token');
    const navigate = useNavigate();

    useEffect(() => { fetchProfs(); }, []);

    const fetchProfs = async () => {
        try {
            const res = await axios.get('http://127.0.0.1:8000/api/professors', {
                headers: { Authorization: `Bearer ${token}` }
            });
            setProfs(res.data.data);
        } catch (err) { console.error(err); }
    };

    const handleAdd = async (e) => {
        e.preventDefault();
        try {
            await axios.post('http://127.0.0.1:8000/api/professors', form, {
                headers: { Authorization: `Bearer ${token}` }
            });
            setForm({ first_name: '', last_name: '', email: '', specialty: '' });
            fetchProfs();
            alert("Professeur ajouté !");
        } catch (err) { alert('Erreur'); }
    };

    const handleDelete = async (id) => {
        if(!confirm('Supprimer ce professeur ?')) return;
        try {
            await axios.delete(`http://127.0.0.1:8000/api/professors/${id}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            fetchProfs();
        } catch (err) { alert('Erreur'); }
    };

    return (
        <div className="container mt-5">
            <h2>👨‍🏫 Gestion des Professeurs</h2>
            <button onClick={() => navigate('/dashboard')} className="btn btn-secondary mb-3">← Retour</button>

            {role === 'admin' && (
                <div className="card mb-4 p-3 shadow-sm border-info">
                    <h5>Ajouter un Professeur</h5>
                    <form onSubmit={handleAdd} className="row g-2">
                        <div className="col-md-3"><input className="form-control" placeholder="Prénom" value={form.first_name} onChange={e => setForm({...form, first_name: e.target.value})} required /></div>
                        <div className="col-md-3"><input className="form-control" placeholder="Nom" value={form.last_name} onChange={e => setForm({...form, last_name: e.target.value})} required /></div>
                        <div className="col-md-3"><input className="form-control" placeholder="Email" value={form.email} onChange={e => setForm({...form, email: e.target.value})} required /></div>
                        <div className="col-md-2"><input className="form-control" placeholder="Spécialité" value={form.specialty} onChange={e => setForm({...form, specialty: e.target.value})} /></div>
                        <div className="col-md-1"><button className="btn btn-info text-white w-100">+</button></div>
                    </form>
                </div>
            )}

            <table className="table table-bordered table-hover">
                <thead className="table-light"><tr><th>Nom Complet</th><th>Email</th><th>Spécialité</th>{role === 'admin' && <th>Action</th>}</tr></thead>
                <tbody>
                    {profs.map(p => (
                        <tr key={p.id}>
                            <td>{p.first_name} {p.last_name}</td>
                            <td>{p.email}</td>
                            <td>{p.specialty}</td>
                            {role === 'admin' && <td><button onClick={() => handleDelete(p.id)} className="btn btn-sm btn-danger">X</button></td>}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}