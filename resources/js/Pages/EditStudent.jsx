import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate, useParams } from 'react-router-dom';

export default function EditStudent() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(true);
    
    const [formData, setFormData] = useState({
        first_name: '', last_name: '', email: '', phone: '', city: '', level: ''
    });

    useEffect(() => {
        const fetchStudent = async () => {
            const token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/students/${id}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });
                const student = response.data.data;
                setFormData({
                    first_name: student.first_name,
                    last_name: student.last_name,
                    email: student.user.email,
                    phone: student.phone,
                    city: student.city,
                    level: student.level
                });
                setLoading(false);
            } catch (error) {
                console.error(error);
                navigate('/dashboard');
            }
        };
        fetchStudent();
    }, [id, navigate]);

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const token = localStorage.getItem('token');
        try {
            await axios.put(`http://127.0.0.1:8000/api/students/${id}`, formData, {
                headers: { Authorization: `Bearer ${token}` }
            });
            alert("Étudiant modifié avec succès !");
            navigate('/dashboard');
        } catch (error) {
            alert("Erreur lors de la modification.");
        }
    };

    if (loading) return <div>Chargement...</div>;

    return (
        <div className="container mt-5">
            <div className="card shadow">
                <div className="card-header bg-warning">
                    <h4>Modifier l'étudiant</h4>
                </div>
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label>Prénom</label>
                            <input name="first_name" className="form-control" value={formData.first_name} onChange={handleChange} />
                        </div>
                        <div className="mb-3">
                            <label>Nom</label>
                            <input name="last_name" className="form-control" value={formData.last_name} onChange={handleChange} />
                        </div>
                        <button type="submit" className="btn btn-warning">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
    );
}