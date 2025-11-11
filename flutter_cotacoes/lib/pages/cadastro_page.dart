import 'package:flutter/material.dart';
import '../services/api_service.dart';

class CadastroPage extends StatefulWidget {
  const CadastroPage({super.key});

  @override
  State<CadastroPage> createState() => _CadastroPageState();
}

class _CadastroPageState extends State<CadastroPage> {
  final _formKey = GlobalKey<FormState>();

  String _tipoUsuario = 'cliente'; // cliente ou entregador
  String _tipoPessoa = 'PF'; // PF = Pessoa Física, PJ = Pessoa Jurídica

  bool loading = false;

  // Campos comuns
  final nomeController = TextEditingController();
  final cpfCnpjController = TextEditingController();
  final emailController = TextEditingController();
  final senhaController = TextEditingController();
  final telefoneController = TextEditingController();

  // Campos cliente
  final enderecoController = TextEditingController();
  final bairroController = TextEditingController();
  final cidadeController = TextEditingController();
  final estadoController = TextEditingController();
  final cepController = TextEditingController();

  Future<void> _salvarCadastro() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => loading = true);

    try {
      final dados = <String, String>{
        "tipo_usuario": _tipoUsuario, // indica qual tabela usar no backend
        "tipo": _tipoUsuario == 'cliente' ? _tipoPessoa : '',
        "nome": nomeController.text.trim(),
        "cpf_cnpj": cpfCnpjController.text.trim(),
        "email": emailController.text.trim(),
        "senha": senhaController.text.trim(),
        "telefone": telefoneController.text.trim(),
        "cidade": cidadeController.text.trim(),
        "estado": estadoController.text.trim(),
      };

      if (_tipoUsuario == 'cliente') {
        dados.addAll({
          "endereco": enderecoController.text.trim(),
          "bairro": bairroController.text.trim(),
          "cep": cepController.text.trim(),
        });
      }

      final resp = await ApiService.cadastrarUsuario(dados);

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(resp['mensagem'] ?? 'Resposta inválida')),
      );

      if (resp['status'] == 'sucesso') {
        Navigator.pop(context); // volta para login
      }
    } catch (e) {
      ScaffoldMessenger.of(context)
          .showSnackBar(SnackBar(content: Text('Erro: $e')));
    } finally {
      setState(() => loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final isCliente = _tipoUsuario == 'cliente';

    return Scaffold(
      appBar: AppBar(
        title: const Text('Cadastro'),
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () => Navigator.pop(context),
        ),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              // Tipo de conta (cliente ou entregador)
              DropdownButtonFormField<String>(
                value: _tipoUsuario,
                decoration: const InputDecoration(labelText: 'Tipo de conta'),
                items: const [
                  DropdownMenuItem(value: 'cliente', child: Text('Cliente')),
                  DropdownMenuItem(value: 'entregador', child: Text('Entregador')),
                ],
                onChanged: (v) => setState(() => _tipoUsuario = v!),
              ),

              const SizedBox(height: 12),

              // Tipo de pessoa (PF ou PJ)
              if (isCliente) ...[
                DropdownButtonFormField<String>(
                  decoration: const InputDecoration(labelText: 'Tipo de pessoa'),
                  value: _tipoPessoa,
                  items: const [
                    DropdownMenuItem(value: 'PF', child: Text('Pessoa Física')),
                    DropdownMenuItem(value: 'PJ', child: Text('Pessoa Jurídica')),
                  ],
                  onChanged: (v) => setState(() => _tipoPessoa = v!),
                ),
                const SizedBox(height: 12),
              ],

              TextFormField(
                controller: nomeController,
                decoration: const InputDecoration(labelText: 'Nome / Razão social'),
                validator: (v) => v == null || v.isEmpty ? 'Informe o nome' : null,
              ),
              TextFormField(
                controller: cpfCnpjController,
                decoration: const InputDecoration(labelText: 'CPF ou CNPJ'),
                validator: (v) => v == null || v.isEmpty ? 'Informe CPF/CNPJ' : null,
              ),
              TextFormField(
                controller: emailController,
                decoration: const InputDecoration(labelText: 'Email'),
                validator: (v) => v == null || v.isEmpty ? 'Informe o e-mail' : null,
              ),
              TextFormField(
                controller: senhaController,
                obscureText: true,
                decoration: const InputDecoration(labelText: 'Senha'),
                validator: (v) => v == null || v.length < 6
                    ? 'Senha com pelo menos 6 caracteres'
                    : null,
              ),
              TextFormField(
                controller: telefoneController,
                decoration: const InputDecoration(labelText: 'Telefone'),
                validator: (v) => v == null || v.isEmpty ? 'Informe o telefone' : null,
              ),

              const SizedBox(height: 12),

              if (isCliente) ...[
                TextFormField(
                  controller: enderecoController,
                  decoration: const InputDecoration(labelText: 'Endereço'),
                  validator: (v) => v == null || v.isEmpty ? 'Informe o endereço' : null,
                ),
                TextFormField(
                  controller: bairroController,
                  decoration: const InputDecoration(labelText: 'Bairro'),
                  validator: (v) => v == null || v.isEmpty ? 'Informe o bairro' : null,
                ),
                TextFormField(
                  controller: cepController,
                  decoration: const InputDecoration(labelText: 'CEP'),
                  validator: (v) => v == null || v.isEmpty ? 'Informe o CEP' : null,
                ),
              ],

              TextFormField(
                controller: cidadeController,
                decoration: const InputDecoration(labelText: 'Cidade'),
                validator: (v) => v == null || v.isEmpty ? 'Informe a cidade' : null,
              ),
              TextFormField(
                controller: estadoController,
                decoration: const InputDecoration(labelText: 'Estado (UF)'),
                validator: (v) => v == null || v.isEmpty ? 'Informe o estado' : null,
              ),

              const SizedBox(height: 24),

              loading
                  ? const CircularProgressIndicator()
                  : ElevatedButton.icon(
                      onPressed: _salvarCadastro,
                      icon: const Icon(Icons.save),
                      label: const Text('Cadastrar'),
                      style: ElevatedButton.styleFrom(
                        minimumSize: const Size(double.infinity, 50),
                      ),
                    ),
            ],
          ),
        ),
      ),
    );
  }
}
