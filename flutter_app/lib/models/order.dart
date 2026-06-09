import 'order_detail.dart';

class Order {
  final int? id;
  final int userId;
  final double totalAmount;
  final String? paymentMethod;
  final String status;
  final String? shippingFullname;
  final String? shippingPhone;
  final String? shippingEmail;
  final String? shippingAddress;
  final DateTime? createdAt;
  final DateTime? updatedAt;
  final List<OrderDetail>? orderDetails;

  Order({
    this.id,
    required this.userId,
    required this.totalAmount,
    this.paymentMethod,
    required this.status,
    this.shippingFullname,
    this.shippingPhone,
    this.shippingEmail,
    this.shippingAddress,
    this.createdAt,
    this.updatedAt,
    this.orderDetails,
  });

  factory Order.fromJson(Map<String, dynamic> json) {
    List<OrderDetail>? details;
    if (json['order_details'] != null) {
      details = (json['order_details'] as List)
          .map((item) => OrderDetail.fromJson(item))
          .toList();
    }
    return Order(
      id: json['id'] as int?,
      userId: json['user_id'] as int,
      totalAmount: (json['total_amount'] as num).toDouble(),
      paymentMethod: json['payment_method'] as String?,
      status: json['status'] as String,
      shippingFullname: json['shipping_fullname'] as String?,
      shippingPhone: json['shipping_phone'] as String?,
      shippingEmail: json['shipping_email'] as String?,
      shippingAddress: json['shipping_address'] as String?,
      createdAt: json['created_at'] != null
          ? DateTime.parse(json['created_at'])
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.parse(json['updated_at'])
          : null,
      orderDetails: details,
    );
  }
}
