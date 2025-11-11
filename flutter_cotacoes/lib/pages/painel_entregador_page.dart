import 'package:flutter/material.dart';
import '../services/api_service.dart';

class PainelEntregadorPage extends StatefulWidget {
  final int entregadorId;
  final String entregadorNome;

  const PainelEntregadorPage({
    super.key,
    required this.entregadorId,
    required this.entregadorNome,
  });

  @override
  State<PainelEntregadorPage> createState() => _PainelEntregadorPageState();
}

class _PainelEntregadorPageState extends State<PainelEntregadorPage> {
  late Future<List<dynamic>> _cotacoes;

  @override
  void initState() {
    super.initState();
    _carregarCotacoes();
  }

  void _carregarCotacoes() {
    setState(() {
      _cotacoes = ApiService.listarCotacoesAprovadas();
    });
  }
  

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Entregador: ${widget.entregadorNome}'),
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () => Navigator.pop(context),
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: _carregarCotacoes,
            tooltip: 'Atualizar lista',
          ),
        ],
      ),
      body: FutureBuilder<List<dynamic>>(
        future: _cotacoes,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }

          if (snapshot.hasError) {
            return Center(child: Text('Erro: ${snapshot.error}'));
          }

          final list = snapshot.data ?? [];
          if (list.isEmpty) {
            return const Center(child: Text('Nenhum Agendamento aprovado.'));
          }

          return RefreshIndicator(
            onRefresh: () async => _carregarCotacoes(),
            child: ListView.builder(
              itemCount: list.length,
              itemBuilder: (_, i) {
                final c = list[i];
                return Card(
                  margin: const EdgeInsets.all(8),
                  child: ListTile(
                    leading: const Icon(Icons.local_shipping),
                    title: Text('${c['remetente']} → ${c['destinatario']}'),
                    subtitle: Text(
                        'Valor: R\$ ${c['valor_frete']} • Data: ${c['data_cotacao']}'),
                    isThreeLine: true,
                    onTap: () {
                      // Aqui você pode abrir detalhes, aceitar ou agendar
                    },
                  ),
                );
              },
            ),
          );
        },
      ),
    );
  }
}
