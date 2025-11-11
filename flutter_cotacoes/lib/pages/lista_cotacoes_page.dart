import 'package:flutter/material.dart';
import '../services/api_service.dart';
import 'editar_cotacao_page.dart';

class ListaCotacoesPage extends StatefulWidget {
  final int usuarioId;

  const ListaCotacoesPage({super.key, required this.usuarioId});

  @override
  State<ListaCotacoesPage> createState() => _ListaCotacoesPageState();
}

class _ListaCotacoesPageState extends State<ListaCotacoesPage> {
  late Future<List<dynamic>> _cotacoes;

  @override
  void initState() {
    super.initState();
    _cotacoes = ApiService.listarCotacoes(widget.usuarioId);
  }

  void _atualizarLista() {
    setState(() {
      _cotacoes = ApiService.listarCotacoes(widget.usuarioId);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Minhas Cotações")),
      body: FutureBuilder<List<dynamic>>(
        future: _cotacoes,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }

          if (snapshot.hasError) {
            return Center(child: Text("Erro: ${snapshot.error}"));
          }

          final cotacoes = snapshot.data ?? [];

          if (cotacoes.isEmpty) {
            return const Center(child: Text("Nenhuma cotação encontrada."));
          }

          return ListView.builder(
            itemCount: cotacoes.length,
            itemBuilder: (context, index) {
              final c = cotacoes[index];

              return Card(
                margin: const EdgeInsets.all(8),
                child: ListTile(
                  leading: CircleAvatar(
                    backgroundColor: Colors.blueAccent,
                    child: Text(c["id"].toString()),
                  ),
                  title: Text("${c["remetente"]} → ${c["destinatario"]}"),
                  subtitle: Text(
                    "Mercadoria: ${c["mercadoria"]}\n"
                    "Valor: R\$ ${c["valor_frete"]} - Pagamento: ${c["pagamento"].toUpperCase()}\n"
                    "Data: ${c["data_cotacao"]}",
                  ),
                  isThreeLine: true,
                  trailing: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      IconButton(
                        icon: const Icon(Icons.edit, color: Colors.orange),
                        onPressed: () async {
                          final atualizado = await Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (_) => EditarCotacaoPage(cotacao: c),
                            ),
                          );

                          if (atualizado == true) {
                            _atualizarLista();
                          }
                        },
                      ),
                      IconButton(
                        icon: const Icon(Icons.delete, color: Colors.red),
                        onPressed: () async {
                          final confirm = await showDialog<bool>(
                            context: context,
                            builder: (context) => AlertDialog(
                              title: const Text("Excluir Cotação"),
                              content: Text(
                                  "Deseja realmente excluir a cotação de ${c["remetente"]}?"),
                              actions: [
                                TextButton(
                                  onPressed: () =>
                                      Navigator.pop(context, false),
                                  child: const Text("Cancelar"),
                                ),
                                ElevatedButton(
                                  onPressed: () =>
                                      Navigator.pop(context, true),
                                  child: const Text("Excluir"),
                                ),
                              ],
                            ),
                          );

                          if (confirm == true) {
                            final sucesso = await ApiService.excluirCotacao(
                                int.parse(c["id"]));
                            if (sucesso) {
                              ScaffoldMessenger.of(context).showSnackBar(
                                const SnackBar(
                                    content: Text(
                                        "Cotação excluída com sucesso!")),
                              );
                              _atualizarLista();
                            } else {
                              ScaffoldMessenger.of(context).showSnackBar(
                                const SnackBar(
                                    content:
                                        Text("Erro ao excluir cotação.")),
                              );
                            }
                          }
                        },
                      ),
                    ],
                  ),
                ),
              );
            },
          );
        },
      ),
    );
  }
}
