class User {
  final int? id;
  final String username;
  final String? email;
  final String? fullname;
  final String? phone;
  final String? address;
  final String? role;

  User({
    this.id,
    required this.username,
    this.email,
    this.fullname,
    this.phone,
    this.address,
    this.role,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'] as int?,
      username: json['username'] as String,
      email: json['email'] as String?,
      fullname: json['fullname'] as String?,
      phone: json['phone'] as String?,
      address: json['address'] as String?,
      role: json['role'] as String?,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'username': username,
      'email': email,
      'fullname': fullname,
      'phone': phone,
      'address': address,
      'role': role,
    };
  }
}
