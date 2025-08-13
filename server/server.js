import express from 'express';
import cors from 'cors';
import apiRouter from './routes/api.js';
import { PORT } from './config.js';

const app = express();

app.use(cors());
app.use(express.json());

// Rutas API
app.use('/api', apiRouter);

app.listen(PORT, () => {
  console.log(`Servidor corriendo en http://localhost:${PORT}`);
});
