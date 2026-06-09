class Product {
  final int? id;
  final String name;
  final String? brand;
  final String? cpu;
  final String? boNhoTrong;
  final String? pin;
  final double price;
  final String? image;
  final String? description;
  final int? quantity;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  Product({
    this.id,
    required this.name,
    this.brand,
    this.cpu,
    this.boNhoTrong,
    this.pin,
    required this.price,
    this.image,
    this.description,
    this.quantity,
    this.createdAt,
    this.updatedAt,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'] as int?,
      name: json['name'] as String,
      brand: json['brand'] as String?,
      cpu: json['cpu'] as String?,
      boNhoTrong: json['bo_nho_trong'] as String?,
      pin: json['pin'] as String?,
      price: (json['price'] as num).toDouble(),
      image: json['image'] as String?,
      description: json['description'] as String?,
      quantity: json['quantity'] as int?,
      createdAt: json['created_at'] != null
          ? DateTime.parse(json['created_at'])
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.parse(json['updated_at'])
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'brand': brand,
      'cpu': cpu,
      'bo_nho_trong': boNhoTrong,
      'pin': pin,
      'price': price,
      'image': image,
      'description': description,
      'quantity': quantity,
    };
  }
}
