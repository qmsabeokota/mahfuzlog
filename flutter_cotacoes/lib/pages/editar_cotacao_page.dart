import 'package:flutter/material.dart';
import '../services/api_service.dart';

class EditarCotacaoPage extends StatefulWidget {
  final Map<String, dynamic> cotacao;

  const EditarCotacaoPage({super.key, required this.cotacao});

  @override
  State<EditarCotacaoPage> createState() => _EditarCotacaoPageState();
}

class _EditarCotacaoPageState extends State<EditarCotacaoPage> {
  final _formKey = GlobalKey<FormState>();

  late TextEditingController _remetente;
  late TextEditingController _destinatario;
  late TextEditingController _mercadoria;
  late TextEditingController _largura;
  late TextEditingController _altura;
  late TextEditingController _comprimento;
  late TextEditingController _peso;
  late TextEditingController _valorFrete;
  String _pagamento = "pix";

  @override
  void initState() {
    super.initState();
    final c = widget.cotacao;
    _remetente = TextEditingController(text: c["remetente"]);
    _destinatario = TextEditingController(text: c["destinatario"]);
    _mercadoria = TextEditingController(text: c["mercadoria"]);
    _largura = TextEditingController(text: c["largura"].toString());
    _altura = TextEditingController(text: c["altura"].toString());
    _comprimento = TextEditingController(text: c["comprimento"].toString());
    _peso = TextEditingController(text: c["peso"].toString());
    _valorFrete = TextEditingController(text: c["valor_frete"].toString());
    _pagamento = c["pagamento"];
  }

void _salvar() async {
  if (_formKey.currentState!.validate()) {
    final sucesso = await ApiService.atualizarCotacao(
      widget.cotacao["id"],
      {
        "remetente": _remetente.text,
        "destinatario": _destinatario.text,
        "mercadoria": _mercadoria.text,
        "largura": double.parse(_largura.text),
        "altura": double.parse(_altura.text),
        "comprimento": double.parse(_comprimento.text),
        "peso": double.parse(_peso.text),
        "valor_frete": double.parse(_valorFrete.text),
        "pagamento": _pagamento,
      },
    );

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          sucesso
              ? "Cotação atualizada com sucesso!"
              : "Erro ao atualizar cotação.",
        ),
      ),
    );

    if (sucesso && mounted) Navigator.pop(context, true);
  }
}

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Editar Cotação")),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: ListView(
            children: [
              TextFormField(controller: _remetente, decoration: const InputDecoration(labelText: "Remetente")),
              TextFormField(controller: _destinatario, decoration: const InputDecoration(labelText: "Destinatário")),
              TextFormField(controller: _mercadoria, decoration: const InputDecoration(labelText: "Mercadoria")),
              TextFormField(controller: _largura, decoration: const InputDecoration(labelText: "Largura (cm)"), keyboardType: TextInputType.number),
              TextFormField(controller: _altura, decoration: const InputDecoration(labelText: "Altura (cm)"), keyboardType: TextInputType.number),
              TextFormField(controller: _comprimento, decoration: const InputDecoration(labelText: "Comprimento (cm)"), keyboardType: TextInputType.number),
              TextFormField(controller: _peso, decoration: const InputDecoration(labelText: "Peso (kg)"), keyboardType: TextInputType.number),
              TextFormField(controller: _valorFrete, decoration: const InputDecoration(labelText: "Valor Frete (R\$)"), keyboardType: TextInputType.number),
              DropdownButtonFormField(
                value: _pagamento,
                decoration: const InputDecoration(labelText: "Pagamento"),
                items: const [
                  DropdownMenuItem(value: "pix", child: Text("PIX")),
                  DropdownMenuItem(value: "cartao", child: Text("Cartão")),
                ],
                onChanged: (v) => setState(() => _pagamento = v!),
              ),
              const SizedBox(height: 20),
              ElevatedButton(onPressed: _salvar, child: const Text("Salvar Alterações")),
            ],
          ),
        ),
      ),
    );
  }
}
