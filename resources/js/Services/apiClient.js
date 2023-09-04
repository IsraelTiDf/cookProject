import axios from "axios";

const apiClient = axios.create({
//   baseURL: process.env.REACT_APP_API_BASE_URL || "/api",
//   baseURL: "/api",
  headers: {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    Accept: "application/json",
  },
  // ...
});

//Ver a guestao se irar pegar os token register quando usuario é logado.

// apiClient.interceptors.request.use((config) => {
//   // Adicionando token de autenticação, se aplicável
//   const token = localStorage.getItem('token');
//   if (token) {
//     config.headers.Authorization = `Bearer ${token}`;
//   }
//   return config;
// });

apiClient.interceptors.response.use(
  function handleResponseSuccess(response) {
    return response;
  },
  function handleResponseError(error) {
    if (error.response.status === 401 || error.response.status === 419) {
      window.location.replace("/login");
      return; // Interrompa a cadeia de promessas aqui
    }

    // Outras manipulações de erro

    return Promise.reject(error);
  }
);

export default apiClient;
