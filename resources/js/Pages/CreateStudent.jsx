import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

export default function CreateStudent() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        first_name: '', last_name: '', email: '', password: '', phone: '', city: '', level: ''
    });
    const [error, setError] = useState('');

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const token = localStorage.getItem('token');
        try {
            await axios.post('http://127.0.0.1:8000/api/students', formData, {
                headers: { Authorization: `Bearer ${token}` }
            });
            alert("Étudiant ajouté avec succès !");
            navigate('/dashboard');
        } catch (err) {
            setError("Erreur lors de la création de l'étudiant.");
        }
    };

    return (
        <div className="container mt-5">
            <div className="card shadow">
                <div className="card-header bg-success text-white">
                    <h4>Ajouter un nouvel étudiant</h4>
                </div>
                <div className="card-body">
                    {error && <div className="alert alert-danger">{error}</div>}
                    <form onSubmit={handleSubmit}>
                        <div className="row">
                            <div className="col-md-6 mb-3">
                                <label>Prénom</label>
                                <input name="first_name" className="form-control" onChange={handleChange} required />
                            </div>
                            <div className="col-md-6 mb-3">
                                <label>Nom</label>
                                <input name="last_name" className="form-control" onChange={handleChange} required />
                            </div>
                        </div>
                        <div className="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" className="form-control" onChange={handleChange} required />
                        </div>
                        <div className="mb-3">
                            <label>Mot de passe</label>
                            <input type="password" name="password" className="form-control" onChange={handleChange} required />
                        </div>
                        <div className="row">
                            <div className="col-md-4 mb-3">
                                <label>Téléphone</label>
                                <input name="phone" className="form-control" onChange={handleChange} />
                            </div>
                            <div className="col-md-4 mb-3">
                                <label>Ville</label>
                                <input name="city" className="form-control" onChange={handleChange} />
                            </div>
                            <div className="col-md-4 mb-3">
                                <label>Niveau</label>
                                <select name="level" className="form-control" onChange={handleChange}>
                                    <option value="">Sélectionner...</option>
                                    <option value="1ère Année">1ère Année</option>
                                    <option value="2ème Année">2ème Année</option>
                                    <option value="3ème Année">3ème Année</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" className="btn btn-success">Enregistrer</button>
                        <button type="button" className="btn btn-secondary ms-2" onClick={() => navigate('/dashboard')}>Annuler</button>
                    </form>
                </div>
            </div>
        </div>
    );
}