class OrderDetail {
  final int? id;
  final int orderId;
  final int productId;
  final int? quantity;
  final double? price;
  final String? productName;
  final String? productImage;

  OrderDetail({
    this.id,
    required this.orderId,
    required this.productId,
    this.quantity,
    this.price,
    this.productName,
    this.productImage,
  });

  factory OrderDetail.fromJson(Map<String, dynamic> json) {
    return OrderDetail(
      id: json['id'] as int?,
      orderId: json['order_id'] as int,
      productId: json['product_id'] as int,
      quantity: json['quantity'] as int?,
      price: json['price'] != null ? (json['price'] as num).toDouble() : null,
      productName: json['name'] as String?,
      productImage: json['image'] as String?,
    );
  }
}
