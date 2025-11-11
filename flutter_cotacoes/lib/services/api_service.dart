import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  static const String baseUrl = "http://10.0.2.2/api_cotacoes";

  // LOGIN 
  static Future<Map<String, dynamic>> login(String email, String senha) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login.php'),
        body: {
          'email': email,
          'senha': senha,
        },
      );

      if (response.statusCode == 200) {
        final decoded = jsonDecode(response.body);
        if (decoded is Map<String, dynamic>) {
          return decoded;
        } else {
          return {
            "status": "erro",
            "mensagem": "Formato de resposta inválido do servidor"
          };
        }
      } else {
        return {
          "status": "erro",
          "mensagem": "Erro de comunicação com o servidor (${response.statusCode})"
        };
      }
    } catch (e) {
      return {
        "status": "erro",
        "mensagem": "Erro inesperado: $e"
      };
    }
  }

  // Inserir cotação
  static Future<bool> inserirCotacao(Map<String, dynamic> dados) async {
    final response = await http.post(
      Uri.parse("$baseUrl/inserir_cotacao.php"),
      headers: {"Content-Type": "application/json"},
      body: jsonEncode(dados),
    );

    try {
      final json = jsonDecode(response.body);
      return json["status"] == "sucesso";
    } catch (e) {
      print("Erro inserirCotacao: $e");
      return false;
    }
  }

  //Listar cotações por usuário
  static Future<List<dynamic>> listarCotacoes(int usuarioId) async {
    final response = await http.get(
      Uri.parse("$baseUrl/listar_cotacoes.php?usuario_id=$usuarioId"),
    );
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception("Erro ao carregar cotações (${response.statusCode})");
    }
  }

  //Listar cotações aprovadas
  static Future<List<dynamic>> listarCotacoesAprovadas() async {
    final response = await http.get(
      Uri.parse("$baseUrl/cotacoes_aprovadas.php"),
    );
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception("Erro ao carregar cotações aprovadas");
    }
  }

  // Atualizar cotação
  static Future<bool> atualizarCotacao(int id, Map<String, dynamic> dados) async {
    final response = await http.post(
      Uri.parse("$baseUrl/atualizar_cotacao.php"),
      headers: {"Content-Type": "application/json"},
      body: jsonEncode({
        "id": id,
        ...dados,
      }),
    );

    try {
      final json = jsonDecode(response.body);
      return json["status"] == "sucesso";
    } catch (e) {
      print("Erro atualizarCotacao: $e");
      return false;
    }
  }

  // Excluir cotação
  static Future<bool> excluirCotacao(int id) async {
    final response = await http.post(
      Uri.parse("$baseUrl/excluir_cotacao.php"),
      headers: {"Content-Type": "application/json"},
      body: jsonEncode({"id": id}),
    );

    try {
      final json = jsonDecode(response.body);
      return json["status"] == "sucesso";
    } catch (e) {
      print("Erro excluirCotacao: $e");
      return false;
    }
  }

  static Future<Map<String, dynamic>> cadastrarUsuario(Map<String, String> dados) async {
  final response = await http.post(
    Uri.parse('$baseUrl/cadastrar.php'),
    body: dados,
  );

  return json.decode(response.body);
}
}
