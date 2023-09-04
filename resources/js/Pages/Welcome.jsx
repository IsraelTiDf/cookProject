import React, { useState, useEffect } from 'react';
import { Link, Head } from '@inertiajs/react';
import {
  Card,
  CardContent,
  CardMedia,
  Typography,
  Grid,
  Container,
  TextField,
  Button,
  Paper,
  Box,
  Slider,
  Slide,
  AppBar,
  Tabs,
  Tab,
  Toolbar
} from '@mui/material';

import CardList from '../Components/cliente/CardList.jsx';
// import apiClient from '../services/apiClient';


export default function Welcome({ auth, produtos }) {
  const [tabValue, setTabValue] = React.useState(0);
  const [cart, setCart] = useState([]);

  const [searchInput, setSearchInput] = useState('');
  const [searchResults, setSearchResults] = useState([]);

  const handleChangeTab = (event, newValue) => {
    setTabValue(newValue);
  };

  const addToCart = (product) => {
    const updatedCart = [...cart];
    const existingProduct = updatedCart.find((item) => item.id === product.id);

    if (existingProduct) {
      existingProduct.quantity++;
    } else {
      updatedCart.push({ ...product, quantity: 1 });
    }

    setCart(updatedCart);
  };

  const removeFromCart = (productId) => {
    const updatedCart = cart.filter((item) => item.id !== productId);
    setCart(updatedCart);
  };



  useEffect(() => {
    const filteredProducts = produtos.filter((product) => {

      return (
        product.nome.toLowerCase().includes(searchInput.toLowerCase())

      );
    });
    setSearchResults(filteredProducts);
  }, [searchInput, produtos]);


  return (
    <>
      <Head title="Restaurante Japonês" />
      <div className="bg-gray-100 dark:bg-gray-900 min-h-screen">
        {/* Cabeçalho */}
        <AppBar position="static" color="primary">
          <Container>
            <Toolbar>
              <Typography variant="h6" component="h1" className="flex-grow-1">
                Bem-vindo ao Restaurante Japonês Sakura
              </Typography>
              <Grid container justifyContent="flex-end" alignItems="center">
                {auth.user ? (
                  <Link
                    href={route('dashboard')}
                    className="text-white mr-3"
                  >
                    Dashboard
                  </Link>
                ) : (
                  <>
                    <Link
                      href={route('login')}
                      className="text-white mr-3"
                    >
                      Log in
                    </Link>
                    {/* <Link
                      href={route('register')}
                      className="text-white"
                    >
                      Register
                    </Link> */}
                  </>
                )}
              </Grid>
            </Toolbar>
          </Container>
        </AppBar>
        <Container>
          <Link
            href={route('list-pedido')}
            className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >
            Ver Pedidos
          </Link>
        </Container>

        {/* Campo de pesquisa */}
        <Container>
          <TextField
            fullWidth
            label="Pesquisar por nome"
            value={searchInput}
            onChange={(e) => setSearchInput(e.target.value)}
            margin="normal"
          />
        </Container>



        <CardList
          searchResults={searchResults}
          addToCart={addToCart}
          cart={cart}
          removeFromCart={removeFromCart}
        />

      </div>

    </>
  );
}
