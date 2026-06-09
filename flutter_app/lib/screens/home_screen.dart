import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/product_provider.dart';
import '../providers/cart_provider.dart';
import '../providers/auth_provider.dart';
import '../models/product.dart';
import '../constants/app_constants.dart';
import 'cart_screen.dart';
import 'product_detail_screen.dart';
import 'orders_screen.dart';
import 'profile_screen.dart';
import 'login_screen.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final TextEditingController _searchController = TextEditingController();
  String? _selectedBrand;

  @override
  void initState() {
    super.initState();
    Future.microtask(() {
      Provider.of<ProductProvider>(context, listen: false).fetchProducts();
    });
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  void _search() {
    Provider.of<ProductProvider>(context, listen: false).fetchProducts(
      search: _searchController.text.trim().isEmpty
          ? null
          : _searchController.text.trim(),
      brand: _selectedBrand,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Phone Store'),
        actions: [
          Consumer<CartProvider>(
            builder: (context, cart, child) {
              return Badge(
                label: Text('${cart.itemCount}'),
                child: IconButton(
                  icon: const Icon(Icons.shopping_cart),
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const CartScreen()),
                    );
                  },
                ),
              );
            },
          ),
          PopupMenuButton<String>(
            onSelected: (value) {
              switch (value) {
                case 'orders':
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => const OrdersScreen()),
                  );
                  break;
                case 'profile':
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => const ProfileScreen()),
                  );
                  break;
                case 'logout':
                  _logout();
                  break;
              }
            },
            itemBuilder: (context) => [
              const PopupMenuItem(
                value: 'orders',
                child: ListTile(
                  leading: Icon(Icons.list_alt),
                  title: Text('My Orders'),
                ),
              ),
              const PopupMenuItem(
                value: 'profile',
                child: ListTile(
                  leading: Icon(Icons.person),
                  title: Text('Profile'),
                ),
              ),
              const PopupMenuDivider(),
              const PopupMenuItem(
                value: 'logout',
                child: ListTile(
                  leading: Icon(Icons.logout),
                  title: Text('Logout'),
                ),
              ),
            ],
          ),
        ],
      ),
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              children: [
                TextField(
                  controller: _searchController,
                  decoration: InputDecoration(
                    hintText: 'Search products...',
                    prefixIcon: const Icon(Icons.search),
                    suffixIcon: IconButton(
                      icon: const Icon(Icons.clear),
                      onPressed: () {
                        _searchController.clear();
                        _search();
                      },
                    ),
                    border: const OutlineInputBorder(),
                  ),
                  onSubmitted: (_) => _search(),
                ),
                const SizedBox(height: 8),
                Consumer<ProductProvider>(
                  builder: (context, provider, child) {
                    return DropdownButtonFormField<String?>(
                      value: _selectedBrand,
                      hint: const Text('Filter by Brand'),
                      isExpanded: true,
                      items: [
                        const DropdownMenuItem(value: null, child: Text('All Brands')),
                        ...provider.brands.map((brand) {
                          return DropdownMenuItem(value: brand, child: Text(brand));
                        }),
                      ],
                      onChanged: (value) {
                        setState(() {
                          _selectedBrand = value;
                        });
                        _search();
                      },
                      decoration: const InputDecoration(
                        border: OutlineInputBorder(),
                        contentPadding: EdgeInsets.symmetric(horizontal: 12),
                      ),
                    );
                  },
                ),
              ],
            ),
          ),
          Expanded(
            child: Consumer<ProductProvider>(
              builder: (context, provider, child) {
                if (provider.isLoading) {
                  return const Center(child: CircularProgressIndicator());
                }
                if (provider.errorMessage != null) {
                  return Center(child: Text(provider.errorMessage!));
                }
                if (provider.products.isEmpty) {
                  return const Center(child: Text('No products found'));
                }
                return RefreshIndicator(
                  onRefresh: () => provider.fetchProducts(),
                  child: GridView.builder(
                    padding: const EdgeInsets.all(16),
                    gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: 2,
                      childAspectRatio: 0.7,
                      crossAxisSpacing: 16,
                      mainAxisSpacing: 16,
                    ),
                    itemCount: provider.products.length,
                    itemBuilder: (context, index) {
                      final product = provider.products[index];
                      return ProductCard(product: product);
                    },
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  Future<void> _logout() async {
    final auth = Provider.of<AuthProvider>(context, listen: false);
    await auth.logout();
    if (mounted) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const LoginScreen()),
      );
    }
  }
}

class ProductCard extends StatelessWidget {
  final Product product;
  const ProductCard({super.key, required this.product});

  @override
  Widget build(BuildContext context) {
    return Card(
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => ProductDetailScreen(product: product)),
          );
        },
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Expanded(
              child: product.image != null
                  ? Image.network(
                      'http://10.0.2.2:3000/assets/images/${product.image!}',
                      fit: BoxFit.cover,
                      errorBuilder: (context, error, stackTrace) {
                        return Image.network(
                          AppConstants.placeholderImage,
                          fit: BoxFit.cover,
                        );
                      },
                    )
                  : Image.network(
                      AppConstants.placeholderImage,
                      fit: BoxFit.cover,
                    ),
            ),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    product.name,
                    style: const TextStyle(fontWeight: FontWeight.bold),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  if (product.brand != null)
                    Text(
                      product.brand!,
                      style: TextStyle(color: Colors.grey[600], fontSize: 12),
                    ),
                  const SizedBox(height: 4),
                  Text(
                    '\$${product.price.toStringAsFixed(0)}',
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      color: Colors.blue,
                    ),
                  ),
                  const SizedBox(height: 8),
                  ElevatedButton.icon(
                    onPressed: () {
                      Provider.of<CartProvider>(context, listen: false).addItem(product);
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Added to cart!')),
                      );
                    },
                    icon: const Icon(Icons.add_shopping_cart, size: 18),
                    label: const Text('Add'),
                    style: ElevatedButton.styleFrom(
                      minimumSize: const Size(double.infinity, 36),
                      padding: EdgeInsets.zero,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
