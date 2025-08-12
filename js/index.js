require('dotenv').config();
const express = require('express');
const cors = require('cors');
const { createClient } = require('@supabase/supabase-js');

const app = express();
app.use(cors());
app.use(express.json());

const supabase = createClient(process.env.SUPABASE_URL, process.env.SUPABASE_ANON_KEY);

app.post('/formulario', async (req, res) => {
  const { nombre, email, mensaje } = req.body;

  const { data, error } = await supabase
    .from('nombre_tabla')
    .insert([{ nombre, email, mensaje }]);

  if (error) {
    return res.status(500).json({ error: error.message });
  }

  res.json({ message: 'Datos guardados correctamente', data });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Servidor corriendo en puerto ${PORT}`);
});
