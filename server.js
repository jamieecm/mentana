require('dotenv').config(); // Carga las variables de .env
const express = require('express');
const cors = require('cors');
const { createClient } = require('@supabase/supabase-js');

const app = express();
const PORT = process.env.PORT || 3000;

// Conexión segura a Supabase usando variables de entorno
const supabaseUrl = process.env.SUPABASE_URL;
const supabaseKey = process.env.SUPABASE_KEY;
const supabase = createClient(supabaseUrl, supabaseKey);

// Middleware
app.use(express.json()); // Habilita la lectura de JSON en las peticiones
app.use(cors()); // Permite peticiones desde el frontend

// Endpoint para el registro de usuarios
app.post('/api/registrar-usuario', async (req, res) => {
    const { usuario, email, password, edad, genero, educacion, estado_civil, region, comuna } = req.body;

    try {
        const { data, error } = await supabase
            .from('registros_usuarios') // Reemplaza con el nombre de tu tabla en Supabase
            .insert([
                { usuario, email, password, edad, genero, educacion, estado_civil, region, comuna }
            ]);

        if (error) {
            console.error('Error de Supabase:', error);
            return res.status(500).json({ success: false, message: 'Error al insertar en la base de datos.' });
        }

        res.status(201).json({ success: true, message: 'Registro exitoso.', data });
    } catch (err) {
        console.error('Error en el servidor:', err);
        res.status(500).json({ success: false, message: 'Error interno del servidor.' });
    }
});

app.listen(PORT, () => {
    console.log(`Servidor escuchando en el puerto ${PORT}`);
});