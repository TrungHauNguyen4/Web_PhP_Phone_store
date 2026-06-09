import 'package:flutter/foundation.dart';
import '../models/product.dart';
import '../services/api_service.dart';

class ProductProvider with ChangeNotifier {
  final ApiService _api = ApiService();
  final List<Product> _products = [];
  final List<String> _brands = [];
  bool _isLoading = false;
  String? _errorMessage;

  List<Product> get products => List.unmodifiable(_products);
  List<String> get brands => List.unmodifiable(_brands);
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;

  Future<void> fetchProducts({String? search, String? brand}) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      _products.clear();
      _products.addAll(await _api.getProducts(search: search, brand: brand));
      
      if (_brands.isEmpty) {
        _brands.clear();
        _brands.addAll(await _api.getBrands());
      }
    } catch (e) {
      _errorMessage = e.toString();
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }
}
