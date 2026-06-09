import 'package:flutter/foundation.dart';
import '../models/order.dart';
import '../services/api_service.dart';

class OrderProvider with ChangeNotifier {
  final ApiService _api = ApiService();
  final List<Order> _orders = [];
  bool _isLoading = false;
  String? _errorMessage;

  List<Order> get orders => List.unmodifiable(_orders);
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;

  Future<void> fetchOrders() async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      _orders.clear();
      _orders.addAll(await _api.getOrders());
    } catch (e) {
      _errorMessage = e.toString();
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<Order?> createOrder({
    required String shippingFullname,
    required String shippingPhone,
    required String shippingEmail,
    required String shippingAddress,
    String paymentMethod = 'transfer',
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final order = await _api.createOrder(
        shippingFullname: shippingFullname,
        shippingPhone: shippingPhone,
        shippingEmail: shippingEmail,
        shippingAddress: shippingAddress,
        paymentMethod: paymentMethod,
      );
      if (order != null) {
        _orders.insert(0, order);
      }
      return order;
    } catch (e) {
      _errorMessage = e.toString();
      return null;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }
}
