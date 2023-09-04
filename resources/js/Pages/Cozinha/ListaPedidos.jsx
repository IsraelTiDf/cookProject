import React, { useState, useEffect } from 'react';
import Paper from '@mui/material/Paper';
import { DataGrid } from '@mui/x-data-grid';

import apiClient from '../../Services/apiClient';




function ListaPedidos({  }) {
    const [pedidos, setPedidos] = useState([]);
    
    // const [lastUpdatedTimestamp, setLastUpdatedTimestamp] = useState(null); 
    //     // useEffect(() => {
    //     //     fetchData();
    //     // }, []);

    // const pollingInterval = 5000;
    // const fetchNewPedidos = async () => {
    //     try {
    //       const response = await apiClient.get('/fetch-pedidos', {
    //         params: {
    //           lastUpdated: lastUpdatedTimestamp, // Envie o timestamp da última atualização conhecida
    //         },
    //       });
      
    //       if (response.data.timeout) {
    //         // Lidar com o tempo limite de espera
    //       } else {
    //         const newPedidos = response.data.Pedidos;
      
    //         if (newPedidos.length > 0) {
    //           // Atualizar a lista de pedidos com os novos pedidos
    //           setPedidos([...pedidos, ...newPedidos]);
      
    //           // Atualizar o timestamp da última atualização
    //           setLastUpdatedTimestamp(Date.now());
    //         }
    //       }
    //     } catch (error) {
    //       // Lidar com erros de solicitação
    //     } finally {
    //       // Agendar a próxima consulta long polling
    //       setTimeout(fetchNewPedidos, pollingInterval); // pollingInterval é o intervalo de consulta em milissegundos
    //     }
    //   };
    
            // useEffect(() => {
            //     fetchNewPedidos();
            //   }, []);
    
        const fetchData = () => {
            apiClient.get("/list-pedidos").then((response) =>
            setPedidos(response.data.Pedidos)
            );
        }
    
        useEffect(() => {
            fetchData();
        }, []);
    
        console.log(pedidos);
  const columns = [
    { field: 'id', headerName: 'ID', flex: 1 },
    { field: 'nome_usuario', headerName: 'Nome do Usuário', flex: 2 },
    { field: 'status', headerName: 'Status', flex: 1 },
    {
      field: 'produtos',
      headerName: 'Produtos',
      flex: 3,
      renderCell: (params) => {
        const produtos = JSON.parse(params.value);

        return (
          <ul>
            {produtos.map((produto) => (
              <li key={produto.id}>
                {produto.nome} - Descrição: {produto.descricao}
              </li>
            ))}
          </ul>
        );
      },
    },
  ];

  const rows = pedidos.map((pedido) => ({
    id: pedido.id,
    nome_usuario: pedido.nome_usuario,
    status: pedido.status,
    created_at: pedido.created_at,
    produtos: pedido.produtos,
  }));

  return (
    <div style={{ height: 400, width: '100%' }}>
      <Paper elevation={3}>
        <h2 style={{ padding: '16px' }}>Lista de Pedidos</h2>
        <div style={{ height: 300, width: '100%' }}>
          <DataGrid
            rows={rows}
            columns={columns}
            pageSize={5}
            disableSelectionOnClick
          />
        </div>
      </Paper>
    </div>
  );
}

export default ListaPedidos;
