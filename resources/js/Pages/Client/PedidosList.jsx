import React, { useEffect, useState } from 'react';
import {
  Container,
  Typography,
  Table,
  TableContainer,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
  Paper,
} from '@mui/material';

// import apiClient from '../../services/apiClient';
// import PedidoProdutos from './PedidoProdutos'; 



  // console.log(pedidos);
  export default function ListarPedidos(props) {
    const pedidos = props.pedidos.original.Pedidos;

    console.log(pedidos);
  return (
    


    <Container>
      <Typography variant="h4" component="h1" gutterBottom>
        Lista de Pedidos
      </Typography>
      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>ID</TableCell>
              <TableCell>Nome</TableCell>
              <TableCell>Status</TableCell>
              {/* <TableCell>Produtos</TableCell> */}
            </TableRow>
          </TableHead>
          <TableBody>
            {pedidos.map((pedido) => (
              <TableRow key={pedido.id}>
                <TableCell>{pedido.id}</TableCell>
                <TableCell>{pedido.nome_usuario}</TableCell>
                <TableCell>{pedido.status}</TableCell>
                {/* <TableCell>
                  {Array.isArray(pedido.produtos) && pedido.produtos.length > 0 ? (
                    <PedidoProdutos produtos={pedido.produtos} />
                  ) : (
                    'Nenhum produto'
                  )}
                </TableCell> */}
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </Container>
  );
};

// export default ListarPedidos;
