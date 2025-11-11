
<h2>Escolha a forma de pagamento:</h2>

<form action="../controller/PagamentoController.php" method="post">
    <input type="hidden" name="metodo" value="mercadopago">
    <button type="submit">Pagar com Mercado Pago</button>
</form>

<form action="../controller/PagamentoController.php" method="post">
    <input type="hidden" name="metodo" value="pagseguro">
    <button type="submit">Pagar com PagSeguro</button>
</form>
