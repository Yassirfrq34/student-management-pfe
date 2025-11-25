import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useNavigate, Link } from 'react-router-dom';

export default function Dashboard() {
    const [students, setStudents] = useState([]);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    
    // 👇 GET THE ROLE
    const role = localStorage.getItem('role');

    useEffect(() => {
        fetchStudents();
    }, []);

    const fetchStudents = async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            navigate('/login');
            return;
        }
        try {
            const response = await axios.get('http://127.0.0.1:8000/api/students', {
                headers: { Authorization: `Bearer ${token}` }
            });
            setStudents(response.data.data);
            setLoading(false);
        } catch (error) {
            if (error.response && error.response.status === 401) {
                localStorage.removeItem('token');
                navigate('/login');
            }
            setLoading(false);
        }
    };

    const handleLogout = () => {
        localStorage.removeItem('token');
        localStorage.removeItem('role');
        navigate('/login');
    };

    const handleDelete = async (id) => {
        if (!confirm("Êtes-vous sûr de vouloir supprimer cet étudiant ?")) {
            return;
        }
        try {
            const token = localStorage.getItem('token');
            await axios.delete(`http://127.0.0.1:8000/api/students/${id}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            setStudents(students.filter(student => student.id !== id));
            alert("Étudiant supprimé avec succès");
        } catch (error) {
            alert("Erreur: Vous n'avez pas la permission.");
        }
    };

    if (loading) return <div className="text-center mt-5">Chargement...</div>;

    return (
        <div className="container mt-5">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2>🎓 Gestion des Étudiants</h2>
                <div>
                    {/* 👇 ONLY SHOW BUTTON IF ADMIN */}
                    {role === 'admin' && (
                        <Link to="/students/create" className="btn btn-success me-2">
                            + Ajouter
                        </Link>
                    )}
                    <button onClick={handleLogout} className="btn btn-danger">Déconnexion</button>
                </div>
            </div>

            <div className="card shadow">
                <div className="card-header bg-primary text-white">
                    <h5 className="mb-0">Liste des étudiants</h5>
                </div>
                <div className="card-body">
                    <table className="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom Complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Niveau</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {students.length > 0 ? (
                                students.map((student) => (
                                    <tr key={student.id}>
                                        <td>{student.id}</td>
                                        <td>{student.first_name} {student.last_name}</td>
                                        <td>{student.user.email}</td>
                                        <td>{student.phone}</td>
                                        <td>{student.level}</td>
                                        <td>
                                            {/* 👇 ONLY SHOW ACTIONS IF ADMIN */}
                                            {role === 'admin' ? (
                                                <>
                                                    <Link 
                                                        to={`/students/edit/${student.id}`} 
                                                        className="btn btn-sm btn-info me-2 text-white"
                                                    >
                                                        Modifier
                                                    </Link>
                                                    <button 
                                                        className="btn btn-sm btn-danger"
                                                        onClick={() => handleDelete(student.id)}
                                                    >
                                                        Supprimer
                                                    </button>
                                                </>
                                            ) : (
                                                <span className="text-muted">Lecture seule</span>
                                            )}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="6" className="text-center">Aucun étudiant trouvé.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}