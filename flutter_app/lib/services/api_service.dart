import 'dart:convert';
import 'package:http/http.dart' as http;
import '../constants/app_constants.dart';
import '../models/user.dart';
import '../models/product.dart';
import '../models/order.dart';

class ApiService {
  static final ApiService _instance = ApiService._internal();
  factory ApiService() => _instance;
  ApiService._internal();

  final Map<String, String> headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  // ==================== AUTH ====================

  Future<User?> login(String username, String password) async {
    final response = await http.post(
      Uri.parse('${AppConstants.baseUrl}/auth/login'),
      headers: headers,
      body: jsonEncode({'username': username, 'password': password}),
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      if (data['success']) {
        return User.fromJson(data['data']['user']);
      }
    }
    return null;
  }

  Future<bool> register({
    required String username,
    required String email,
    required String password,
    required String passwordConfirm,
    String? fullname,
  }) async {
    final response = await http.post(
      Uri.parse('${AppConstants.baseUrl}/auth/register'),
      headers: headers,
      body: jsonEncode({
        'username': username,
        'email': email,
        'password': password,
        'password_confirm': passwordConfirm,
        'fullname': fullname,
      }),
    );

    return response.statusCode == 201;
  }

  Future<bool> logout() async {
    final response = await http.post(
      Uri.parse('${AppConstants.baseUrl}/auth/logout'),
      headers: headers,
    );

    return response.statusCode == 200;
  }

  // ==================== PRODUCTS ====================

  Future<List<Product>> getProducts({String? search, String? brand}) async {
    String url = '${AppConstants.baseUrl}/products';
    final params = <String, String>{};
    if (search != null) params['search'] = search;
    if (brand != null) params['brand'] = brand;
    if (params.isNotEmpty) {
      url += '?${Uri(queryParameters: params).query}';
    }

    final response = await http.get(Uri.parse(url), headers: headers);

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      if (data['success']) {
        return (data['data']['products'] as List)
            .map((json) => Product.fromJson(json))
            .toList();
      }
    }
    return [];
  }

  Future<Product?> getProduct(int id) async {
    final response = await http.get(
      Uri.parse('${AppConstants.baseUrl}/products/$id'),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      if (data['success']) {
        return Product.fromJson(data['data']['product']);
      }
    }
    return null;
  }

  Future<List<String>> getBrands() async {
    final response = await http.get(
      Uri.parse('${AppConstants.baseUrl}/products'),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      if (data['success'] && data['data']['brands'] != null) {
        return List<String>.from(data['data']['brands']);
      }
    }
    return [];
  }

  // ==================== ORDERS ====================

  Future<List<Order>> getOrders() async {
    final response = await http.get(
      Uri.parse('${AppConstants.baseUrl}/orders'),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      if (data['success']) {
        return (data['data']['orders'] as List)
            .map((json) => Order.fromJson(json))
            .toList();
      }
    }
    return [];
  }

  Future<Order?> createOrder({
    required String shippingFullname,
    required String shippingPhone,
    required String shippingEmail,
    required String shippingAddress,
    String paymentMethod = 'transfer',
  }) async {
    final response = await http.post(
      Uri.parse('${AppConstants.baseUrl}/orders'),
      headers: headers,
      body: jsonEncode({
        'shipping_fullname': shippingFullname,
        'shipping_phone': shippingPhone,
        'shipping_email': shippingEmail,
        'shipping_address': shippingAddress,
        'payment_method': paymentMethod,
      }),
    );

    if (response.statusCode == 201) {
      final data = jsonDecode(response.body);
      if (data['success']) {
        return Order.fromJson(data['data']['order']);
      }
    }
    return null;
  }

  // ==================== USERS ====================

  Future<User?> getProfile() async {
    final response = await http.get(
      Uri.parse('${AppConstants.baseUrl}/users/profile'),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      if (data['success']) {
        return User.fromJson(data['data']['user']);
      }
    }
    return null;
  }

  Future<bool> updateProfile({
    required String fullname,
    required String email,
    String? phone,
    String? address,
  }) async {
    final response = await http.put(
      Uri.parse('${AppConstants.baseUrl}/users/profile'),
      headers: headers,
      body: jsonEncode({
        'fullname': fullname,
        'email': email,
        'phone': phone,
        'address': address,
      }),
    );

    return response.statusCode == 200;
  }

  Future<bool> changePassword({
    required String currentPassword,
    required String newPassword,
    required String passwordConfirm,
  }) async {
    final response = await http.put(
      Uri.parse('${AppConstants.baseUrl}/users/password'),
      headers: headers,
      body: jsonEncode({
        'current_password': currentPassword,
        'new_password': newPassword,
        'password_confirm': passwordConfirm,
      }),
    );

    return response.statusCode == 200;
  }
}
