import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';

// Import Pages
import Login from './Pages/Login.jsx';
import Dashboard from './Pages/Dashboard.jsx';
import CreateStudent from './Pages/CreateStudent.jsx';
import EditStudent from './Pages/EditStudent.jsx';
import Subjects from './Pages/Subjects.jsx'; 
import Professors from './Pages/Professors.jsx';

function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Navigate to="/login" />} />
                <Route path="/login" element={<Login />} />
                <Route path="/dashboard" element={<Dashboard />} />
                <Route path="/professors" element={<Professors />} />
                {/* Students */}
                <Route path="/students/create" element={<CreateStudent />} />
                <Route path="/students/edit/:id" element={<EditStudent />} /> 
                
                {/* Subjects (New Route) */}
                <Route path="/subjects" element={<Subjects />} />
            </Routes>
        </BrowserRouter>
    );
}

if (document.getElementById('app')) {
    const Index = ReactDOM.createRoot(document.getElementById("app"));
    Index.render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
}