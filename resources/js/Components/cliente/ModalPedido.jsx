import React, { useState } from 'react';
import {
  useForm,
  Controller,
  FormProvider,
  useFormContext,
} from 'react-hook-form';
import {
  Box,
  Button,
  Grid,
  TextField,
  Typography,
  List,
  FormHelperText,
  ListItem,
  ListItemText,
  Dialog,
  DialogActions,
  DialogContent,
  DialogContentText,
  DialogTitle,
  Select,
  FormControl,
  InputLabel,
  MenuItem,
  Tooltip,
  Autocomplete,
  Divider,
} from '@mui/material';
import ThumbUpIcon from '@mui/icons-material/ThumbUp';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import apiClient from '../../Services/apiClient';
import LoadingButton from '@mui/lab/LoadingButton';
import { yupResolver } from '@hookform/resolvers/yup';
import * as yup from 'yup';
import InputMask from 'react-input-mask';


export default function ModalPedido(props) {
  const {
    control,
    handleSubmit,
    setValue,
    getValues,
    reset,
    register,
    watch,
    formState: { errors },
  } = useForm({
    reValidateMode: 'onBlur',
    defaultValues: {
      nome: '',
      formaPagamento: '',
      numeroCartao: '',
      dataExpiracao: '',
      codigoSeguranca: '',
    },
  });
  const [loading, setLoading] = React.useState(false);
  const [open, setOpen] = React.useState(false);
  const [valid, setValid] = React.useState(false);

  console.log(props.total);

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleOnSubmit = async (data) => {
    data.dados = props.dados;
    data.preco = props.total;

    apiClient
      .post(`/creat-pedido`, data)
      .then(function (response) {
        handleClose();
        reset();
        setLoading(false);
        setValid(true);
      })
      .catch(function ({ response }) { });
  };

  const formaPagamento = watch('formaPagamento');

  return (
    <div>
      <Tooltip title="Finalizar Pedido">
        <Button variant="contained" color="primary" onClick={handleClickOpen}>
          Finalizar Pedido
        </Button>
      </Tooltip>

      <Dialog open={open} onClose={handleClose} fullWidth>
        <Box component="form" onSubmit={handleSubmit(handleOnSubmit)}>
          <DialogTitle>Finalização de Pedidos</DialogTitle>

          <DialogContent>


            <Grid container spacing={2}> {/* Use um Grid container */}
            <Grid item xs={12} >
              <TextField
                fullWidth
                label="Total"
                variant="standard"
                value={`R$ ${props.total}`} // Exibe o valor total
                InputProps={{readOnly: true,}}
              />
            </Grid>
              <Grid item xs={12}>
                <TextField
                  fullWidth
                  label="Nome"
                  variant="standard"
                  {...register('nome')}
                  error={!!errors.nome}
                  helperText={errors.nome?.message}
                />
              </Grid>

              <Grid item xs={12}>
                <FormControl fullWidth>
                  <InputLabel>Forma de Pagamento</InputLabel>
                  <Select
                    label="Forma de Pagamento"
                    variant="standard"
                    {...register('formaPagamento')}
                    error={!!errors.formaPagamento}
                  >
                    <MenuItem value="CREDITO">Cartão de Crédito</MenuItem>
                    <MenuItem value="DEBITO">Cartão de Débito</MenuItem>
                    <MenuItem value="DINHEIRO">Dinheiro</MenuItem>
                  </Select>
                  <FormHelperText error={!!errors.formaPagamento}>
                    {errors.formaPagamento?.message}
                  </FormHelperText>
                </FormControl>
              </Grid>

              {formaPagamento === 'CREDITO' || formaPagamento === 'DEBITO' ? (
                <Grid item xs={12}>
                  <Divider />
                </Grid>
              ) : null}

              {formaPagamento === 'CREDITO' || formaPagamento === 'DEBITO' ? (
                <>
                  <Grid item xs={12}>
                    <Controller
                      name="numeroCartao"
                      control={control}
                      defaultValue=""
                      render={({ field }) => (
                        <InputMask
                          mask="9999 9999 9999 9999"
                          maskChar=""
                          value={field.value}
                          onChange={(e) => field.onChange(e.target.value)}
                        >
                          {() => (
                            <TextField
                              fullWidth
                              label="Número do Cartão"
                              variant="standard"
                              error={!!errors.numeroCartao}
                              helperText={errors.numeroCartao?.message}
                              InputProps={{
                                endAdornment: valid && (
                                  <CheckCircleIcon style={{ color: 'green' }} />
                                ),
                              }}
                            />
                          )}
                        </InputMask>
                      )}
                    />
                  </Grid>

                  <Grid item xs={12}>
                    <Controller
                      name="dataExpiracao"
                      control={control}
                      defaultValue=""
                      render={({ field }) => (
                        <InputMask
                          mask="99/99"
                          maskChar=""
                          value={field.value}
                          onChange={(e) => field.onChange(e.target.value)}
                        >
                          {() => (
                            <TextField
                              fullWidth
                              label="Data de Expiração"
                              variant="standard"
                              error={!!errors.dataExpiracao}
                              helperText={errors.dataExpiracao?.message}
                              InputProps={{
                                endAdornment: valid && (
                                  <CheckCircleIcon style={{ color: 'green' }} />
                                ),
                              }}
                            />
                          )}
                        </InputMask>
                      )}
                    />
                  </Grid>

                  <Grid item xs={12}>
                    <Controller
                      name="codigoSeguranca"
                      control={control}
                      defaultValue=""
                      render={({ field }) => (
                        <InputMask
                          mask="999"
                          maskChar=""
                          value={field.value}
                          onChange={(e) => field.onChange(e.target.value)}
                        >
                          {() => (
                            <TextField
                              fullWidth
                              label="Código de Segurança"
                              variant="standard"
                              error={!!errors.codigoSeguranca}
                              helperText={errors.codigoSeguranca?.message}
                              InputProps={{
                                endAdornment: valid && (
                                  <CheckCircleIcon style={{ color: 'green' }} />
                                ),
                              }}
                            />
                          )}
                        </InputMask>
                      )}
                    />
                  </Grid>
                </>
              ) : null}
            </Grid>
          </DialogContent>

          <DialogActions>
            <Button onClick={handleClose} color="inherit">
              Cancelar
            </Button>
            <LoadingButton
              color="success"
              type="submit"
              loading={loading}
              loadingPosition="start"
              startIcon={<ThumbUpIcon />}
              variant="contained"
            >
              <span>Confirmar</span>
            </LoadingButton>
          </DialogActions>
        </Box>
      </Dialog>
    </div>
  );
}
