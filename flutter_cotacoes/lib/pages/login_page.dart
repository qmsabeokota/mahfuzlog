import 'dart:convert';
import 'package:flutter/material.dart';
import '../services/api_service.dart';
import 'painel_usuario_page.dart';
import 'dashboard_entregador_page.dart';
import 'cadastro_page.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final emailController = TextEditingController();
  final senhaController = TextEditingController();
  bool loading = false;

  Future<void> _submit() async {
    setState(() => loading = true);
    try {
      final resp = await ApiService.login(
        emailController.text.trim(),
        senhaController.text.trim(),
      );

      setState(() => loading = false);

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(resp['mensagem'] ?? 'Resposta inválida')),
      );

      if (resp['status'] == 'sucesso') {
        final usuario = resp['usuario'];
        final tipo = resp['tipo'];

        if (tipo == 'cliente') {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (_) => PainelUsuarioPage(
                usuarioId: int.parse(usuario['id'].toString()),
                usuarioNome: usuario['nome'],
              ),
            ),
          );
        } else if (tipo == 'entregador') {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (_) => DashboardEntregadorPage(
                entregadorId: int.parse(usuario['id'].toString()),
                entregadorNome: usuario['nome'],
              ),
            ),
          );
        } else {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Tipo de usuário desconhecido')),
          );
        }
      }
    } catch (e) {
      setState(() => loading = false);
      ScaffoldMessenger.of(context)
          .showSnackBar(SnackBar(content: Text('Erro: $e')));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Login')),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextField(
              controller: emailController,
              decoration: const InputDecoration(labelText: 'Email'),
            ),
            TextField(
              controller: senhaController,
              obscureText: true,
              decoration: const InputDecoration(labelText: 'Senha'),
            ),
            const SizedBox(height: 16),
            loading
                ? const CircularProgressIndicator()
                : Column(
                    children: [
                      ElevatedButton(
                        onPressed: _submit,
                        child: const Text('Entrar'),
                      ),
                      const SizedBox(height: 12),
                      // 👇 Botão de cadastro com o mesmo estilo
                      ElevatedButton(
                        onPressed: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (_) => const CadastroPage(),
                            ),
                          );
                        },
                        child: const Text('Cadastrar'),
                      ),
                    ],
                  ),
          ],
        ),
      ),
    );
  }
}
