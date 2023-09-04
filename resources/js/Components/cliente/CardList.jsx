import React from 'react';
import {
  Card,
  CardContent,
  CardMedia,
  Typography,
  Grid,
  Container,
  Button,
  Paper,
} from '@mui/material';

import ModalPedido from '../cliente/ModalPedido.jsx';

export default function CardList({ searchResults, addToCart, cart, removeFromCart }) {
  const total = cart.reduce((total, item) => total + item.preco * item.quantity, 0);

  return (
    <Grid container direction="column" alignItems="center" style={{ minHeight: '100vh' }}>
      <Container>
        <Typography variant="h5" component="h2" gutterBottom>
          Cardápio Completo
        </Typography>
        <Grid container spacing={3}>
          {searchResults.map((product) => (
            <Grid item key={product.id} xs={12} sm={6} md={4} lg={3}>
              <Card className="elevation" style={{ display: 'flex', flexDirection: 'column', height: '100%' }}>
                <CardMedia
                  component="img"
                  alt={product.nome}
                  image={product.image}
                  title={product.nome}
                  style={{ height: '150px'}}
                />
                <CardContent style={{ flex: 1 }}>
                  <Typography variant="h6" component="div">
                    {product.nome}
                  </Typography>
                  <Typography variant="body2" color="textSecondary">
                    {product.descricao}
                  </Typography>
                  <Typography variant="body2" color="textPrimary">
                    {product.preco}
                  </Typography>
                  <Button
                    variant="contained"
                    color="primary"
                    onClick={() => addToCart(product)}
                  >
                    Adicionar ao Carrinho
                  </Button>
                </CardContent>
              </Card>
            </Grid>
          ))}
        </Grid>
      </Container>
      <Paper elevation={3} className="py-4 px-2" style={{ position: 'fixed', bottom: 0, width: '100%' }}>
        <Typography variant="h6">Carrinho de Compras</Typography>
        <ul>
          {cart.map((item) => (
            <li key={item.id}>
              {item.nome} - {item.quantity} - R${(item.preco * item.quantity).toFixed(2)}
              <Button onClick={() => removeFromCart(item.id)}>Remover</Button>
            </li>
          ))}
        </ul>
        <Typography variant="h6">
          Total: R${total.toFixed(2)}
        </Typography>
        <ModalPedido dados={cart} total={total} />
      </Paper>
    </Grid>
  );
}
