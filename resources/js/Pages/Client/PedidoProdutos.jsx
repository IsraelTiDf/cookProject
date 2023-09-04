import React from 'react';

export default function PedidoProdutos({ produtos }) {
  return (
    <ul>
      {produtos.map((produto) => (
        <li key={produto.id}>
          Nome: {produto.nome}, Descrição: {produto.descricao}, Preço: ${produto.preco}, Quantidade: {produto.quantity}
        </li>
      ))}
    </ul>
  );
}