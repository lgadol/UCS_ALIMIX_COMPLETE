import React from 'react';
import { Routes, Route, Navigate } from "react-router-dom";

import Home from '../components/pages/Home.js';
import Movimentacao from '../components/pages/Movimentacao.js';

export default props => (
    <Routes>
        <Route path="/" element={<Navigate to="/home" />} />
        <Route path="/home" element={<Home />} />
        <Route path="/movimentacao" element={<Movimentacao />} />
    </Routes>
)