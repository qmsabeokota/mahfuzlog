import 'package:flutter/material.dart';
import '../services/api_service.dart';
import 'lista_cotacoes_page.dart';

class CotacaoPage extends StatefulWidget {
  final int usuarioId;
  final String usuarioNome;

  const CotacaoPage({
    Key? key,
    required this.usuarioId,
    required this.usuarioNome,
  }) : super(key: key);

  @override
  State<CotacaoPage> createState() => _CotacaoPageState();
}

class _CotacaoPageState extends State<CotacaoPage> {
  final _formKey = GlobalKey<FormState>();

  final _remetente = TextEditingController();
  final _destinatario = TextEditingController();
  final _mercadoria = TextEditingController();
  final _largura = TextEditingController();
  final _altura = TextEditingController();
  final _comprimento = TextEditingController();
  final _peso = TextEditingController();
  final _valorFrete = TextEditingController();
  String _pagamento = "pix";

  @override
  void initState() {
    super.initState();

    // Sempre que o usuário digitar novas dimensões/peso, recalcula automaticamente
    _largura.addListener(_calcularFrete);
    _altura.addListener(_calcularFrete);
    _comprimento.addListener(_calcularFrete);
    _peso.addListener(_calcularFrete);
  }

  void _calcularFrete() {
    final largura = double.tryParse(_largura.text) ?? 0;
    final altura = double.tryParse(_altura.text) ?? 0;
    final comprimento = double.tryParse(_comprimento.text) ?? 0;
    final peso = double.tryParse(_peso.text) ?? 0;

    // Fórmula simples de cálculo de frete
    final valor = (peso * 2.5) + ((largura * altura * comprimento) / 5000);

    setState(() {
      _valorFrete.text = valor.toStringAsFixed(2);
    });
  }

  Future<void> _salvar() async {
    if (_formKey.currentState!.validate()) {
      final sucesso = await ApiService.inserirCotacao({
        "cliente_id": widget.usuarioId,
        "remetente": _remetente.text,
        "destinatario": _destinatario.text,
        "mercadoria": _mercadoria.text,
        "largura": double.tryParse(_largura.text) ?? 0,
        "altura": double.tryParse(_altura.text) ?? 0,
        "comprimento": double.tryParse(_comprimento.text) ?? 0,
        "peso": double.tryParse(_peso.text) ?? 0,
        "valor_frete": double.tryParse(_valorFrete.text) ?? 0,
        "pagamento": _pagamento,
      });

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            sucesso
                ? 'Cotação cadastrada com sucesso!'
                : 'Erro ao salvar cotação',
          ),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Bem-vindo, ${widget.usuarioNome}")),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: ListView(
            children: [
              TextFormField(
                  controller: _remetente,
                  decoration: const InputDecoration(labelText: "Remetente")),
              TextFormField(
                  controller: _destinatario,
                  decoration: const InputDecoration(labelText: "Destinatário")),
              TextFormField(
                  controller: _mercadoria,
                  decoration: const InputDecoration(labelText: "Mercadoria")),
              TextFormField(
                  controller: _largura,
                  decoration:
                      const InputDecoration(labelText: "Largura (cm)"),
                  keyboardType: TextInputType.number),
              TextFormField(
                  controller: _altura,
                  decoration:
                      const InputDecoration(labelText: "Altura (cm)"),
                  keyboardType: TextInputType.number),
              TextFormField(
                  controller: _comprimento,
                  decoration:
                      const InputDecoration(labelText: "Comprimento (cm)"),
                  keyboardType: TextInputType.number),
              TextFormField(
                  controller: _peso,
                  decoration:
                      const InputDecoration(labelText: "Peso (kg)"),
                  keyboardType: TextInputType.number),
              TextFormField(
                controller: _valorFrete,
                decoration: const InputDecoration(labelText: "Valor Frete (R\$)"),
                keyboardType: TextInputType.number,
                readOnly: true, // ✅ não editável — calculado automaticamente
              ),
              DropdownButtonFormField<String>(
                value: _pagamento,
                decoration: const InputDecoration(labelText: "Pagamento"),
                items: const [
                  DropdownMenuItem(value: "pix", child: Text("PIX")),
                  DropdownMenuItem(value: "cartao", child: Text("Cartão")),
                ],
                onChanged: (v) => setState(() => _pagamento = v!),
              ),
              const SizedBox(height: 16),
              ElevatedButton(
                  onPressed: _salvar,
                  child: const Text("Salvar Cotação")),
              ElevatedButton(
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (_) => ListaCotacoesPage(usuarioId: widget.usuarioId),
                    ),
                  );
                },
                child: const Text("Ver Cotações"),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
