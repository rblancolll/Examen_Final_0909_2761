<template>
    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary display-4">Datos de la API de Picsum</h2>

        <!-- Mostrar mensaje de error si ocurre -->
        <div v-if="error" class="alert alert-danger text-center">{{ error }}</div>

        <!-- Spinner de carga mientras se obtienen los datos -->
        <div v-if="loading" class="d-flex justify-content-center align-items-center my-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>

        <!-- Lista de imágenes cargadas -->
        <div v-if="images.length > 0" class="card shadow-lg p-4">
            <ul class="list-group list-group-flush">
                <li v-for="image in images" :key="image.id" class="list-group-item d-flex align-items-center">
                    <img :src="image.download_url" alt="Imagen de Picsum" class="image-preview rounded-circle me-4">
                    <div class="image-info flex-grow-1">
                        <h4 class="mb-1 text-primary">{{ image.author }}</h4>
                        <p class="mb-0 text-secondary">Descargar:</p>
                        <a :href="image.download_url" target="_blank" class="text-decoration-none fw-bold text-dark">{{ image.download_url }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            images: [],
            error: null,
            loading: false
        };
    },
    mounted() {
        this.fetchPicsumData();
    },
    methods: {
        fetchPicsumData() {
            this.loading = true;

            axios.get('https://picsum.photos/v2/list')
                .then(response => {
                    if (response.data && Array.isArray(response.data)) {
                        this.images = response.data;
                    } else {
                        this.error = 'Los datos recibidos no son válidos.';
                        console.error('Datos recibidos:', response.data);
                    }
                })
                .catch(error => {
                    if (error.response) {
                        this.error = `Error ${error.response.status}: ${error.response.data.message || error.response.statusText}`;
                        console.error('Error con respuesta:', error.response);
                    } else if (error.request) {
                        this.error = 'No se recibió una respuesta del servidor de la API de Picsum.';
                        console.error('Error en la solicitud:', error.request);
                    } else {
                        this.error = `Error al cargar los datos: ${error.message}`;
                        console.error('Error:', error.message);
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>

<style>
.container {
    max-width: 900px;
}

.spinner-border {
    display: block;
    margin: 20px auto;
}

.image-preview {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 3px solid #007bff;
    transition: transform 0.2s;
}

.image-preview:hover {
    transform: scale(1.1);
}

.image-info {
    font-size: 1.2em;
}

.text-primary {
    color: #007bff !important;
}

.card {
    border: none;
    border-radius: 12px;
}

.list-group-item {
    padding: 25px 30px;
    display: flex;
    align-items: center;
    gap: 25px;
    transition: background-color 0.2s;
}

.list-group-item:hover {
    background-color: #f7f9fb;
}

a.text-decoration-none:hover {
    text-decoration: underline;
}
</style>
