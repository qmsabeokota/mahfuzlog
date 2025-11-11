import 'package:flutter/material.dart';
import 'cotacao_page.dart';
import 'lista_cotacoes_page.dart';
import 'login_page.dart'; // 👈 Importa para voltar ao LoginPage

class PainelUsuarioPage extends StatelessWidget {
  final int usuarioId;
  final String usuarioNome;

  const PainelUsuarioPage({
    super.key,
    required this.usuarioId,
    required this.usuarioNome,
  });

  void _logout(BuildContext context) {
    showDialog(
      context: context,
      builder: (_) => AlertDialog(
        title: const Text("Sair do sistema"),
        content: const Text("Tem certeza que deseja sair?"),
        actions: [
          TextButton(
            child: const Text("Cancelar"),
            onPressed: () => Navigator.pop(context),
          ),
          TextButton(
            child: const Text("Sair", style: TextStyle(color: Colors.red)),
            onPressed: () {
              Navigator.pop(context); // Fecha o diálogo
              Navigator.pushAndRemoveUntil(
                context,
                MaterialPageRoute(builder: (_) => LoginPage()), // 👈 volta ao login
                (route) => false, // 🔥 limpa o histórico de navegação
              );
            },
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Bem-vindo, $usuarioNome 👋"),
        automaticallyImplyLeading: false,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            const SizedBox(height: 20),
            ElevatedButton.icon(
              icon: const Icon(Icons.add_box_outlined),
              label: const Text("Realizar Nova Cotação"),
              style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.symmetric(vertical: 20),
                textStyle: const TextStyle(fontSize: 18),
              ),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (_) => CotacaoPage(
                      usuarioId: usuarioId,
                      usuarioNome: usuarioNome,
                    ),
                  ),
                );
              },
            ),
            const SizedBox(height: 20),
            ElevatedButton.icon(
              icon: const Icon(Icons.list_alt),
              label: const Text("Acompanhar Minhas Cotações"),
              style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.symmetric(vertical: 20),
                textStyle: const TextStyle(fontSize: 18),
              ),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (_) => ListaCotacoesPage(usuarioId: usuarioId),
                  ),
                );
              },
            ),
            const Spacer(),
            TextButton.icon(
              icon: const Icon(Icons.logout, color: Colors.red),
              label: const Text(
                "Sair",
                style: TextStyle(color: Colors.red, fontSize: 16),
              ),
              onPressed: () => _logout(context),
            ),
          ],
        ),
      ),
    );
  }
}
