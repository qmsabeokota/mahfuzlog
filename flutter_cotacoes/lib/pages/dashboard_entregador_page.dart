import 'package:flutter/material.dart';
import '../services/api_service.dart';
import 'painel_entregador_page.dart';
import 'login_page.dart';
class DashboardEntregadorPage extends StatefulWidget {
  final int entregadorId;
  final String entregadorNome;

  const DashboardEntregadorPage({
    super.key,
    required this.entregadorId,
    required this.entregadorNome,
  });

  @override
  State<DashboardEntregadorPage> createState() => _DashboardEntregadorPageState();
}

class _DashboardEntregadorPageState extends State<DashboardEntregadorPage> {
  late Future<List<dynamic>> _cotacoes;

  @override
  void initState() {
    super.initState();
    _cotacoes = ApiService.listarCotacoesAprovadas();
  }
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
        title: Text('Dashboard do Entregador'),
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () => _logout(context),
        ),
      ),
      body: FutureBuilder<List<dynamic>>(
        future: _cotacoes,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }

          if (snapshot.hasError) {
            return Center(child: Text('Erro ao carregar dados: ${snapshot.error}'));
          }

          final cotacoes = snapshot.data ?? [];
          final totalCotacoes = cotacoes.length;
          final totalEntregas = 0; // depois pode vir da API também

          return Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                Text(
                  'Olá, ${widget.entregadorNome} 👋',
                  style: const TextStyle(
                    fontSize: 22,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 20),

                // Cards de estatísticas
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    _buildCard(
                      icon: Icons.local_shipping,
                      label: 'Cotações Aprovadas',
                      value: '$totalCotacoes',
                      color: Colors.blueAccent,
                    ),
                    _buildCard(
                      icon: Icons.check_circle,
                      label: 'Entregas Feitas',
                      value: '$totalEntregas',
                      color: Colors.green,
                    ),
                  ],
                ),

                const SizedBox(height: 40),

                ElevatedButton.icon(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (_) => PainelEntregadorPage(
                          entregadorId: widget.entregadorId,
                          entregadorNome: widget.entregadorNome,
                        ),
                      ),
                    );
                  },
                  icon: const Icon(Icons.list),
                  label: const Text('Ver Cotações Aprovadas'),
                  style: ElevatedButton.styleFrom(
                    padding: const EdgeInsets.symmetric(vertical: 14),
                    textStyle: const TextStyle(fontSize: 18),
                  ),
                ),

                const SizedBox(height: 16),

                OutlinedButton.icon(
                  onPressed: () => _logout(context),
                  icon: const Icon(Icons.logout),
                  label: const Text('Sair'),
                  style: OutlinedButton.styleFrom(
                    padding: const EdgeInsets.symmetric(vertical: 14),
                    textStyle: const TextStyle(fontSize: 18),
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }

  Widget _buildCard({
    required IconData icon,
    required String label,
    required String value,
    required Color color,
  }) {
    return Expanded(
      child: Card(
        elevation: 4,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            children: [
              Icon(icon, size: 40, color: color),
              const SizedBox(height: 10),
              Text(
                value,
                style: TextStyle(
                  fontSize: 22,
                  fontWeight: FontWeight.bold,
                  color: color,
                ),
              ),
              const SizedBox(height: 6),
              Text(label, textAlign: TextAlign.center),
            ],
          ),
        ),
      ),
    );
  }
}
