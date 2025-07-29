// =====================================================================
//  Sketch Processing sebagai Jembatan Arduino ke Web
// =====================================================================

import processing.serial.*; // Library untuk komunikasi serial
import http.requests.*;     // Library untuk mengirim data ke web

Serial myPort; // Objek untuk port serial

// --- PENGATURAN YANG PERLU ANDA UBAH ---

// 1. Ganti angka '0' dengan nomor port serial Arduino Anda.
//    Untuk melihat daftarnya, jalankan sketch ini sekali. Daftar port akan muncul di konsol di bawah.
//    Contoh: Jika port Anda COM3, dan itu adalah port ke-1 dalam daftar, maka ganti 0 dengan 0.
//    Jika port Anda COM7, dan itu adalah port ke-3 dalam daftar, maka ganti 0 dengan 2.
int portIndex = 1; 

// 2. Ganti dengan URL API CodeIgniter Anda (karena Anda pakai 'spark serve')
String apiUrl = "http://localhost:8080/api/record";

// --- AKHIR PENGATURAN ---


void setup() {
  size(400, 200); // Ukuran jendela aplikasi
  
  // Mencetak daftar semua port serial yang tersedia ke konsol di bawah
  println("Port Serial yang Tersedia:");
  // Mengatasi warning pada beberapa versi Processing
  println((Object)Serial.list()); 
  
  // Membuka koneksi ke port serial yang dipilih
  try {
    String portName = Serial.list()[portIndex];
    myPort = new Serial(this, portName, 9600);
    println("Berhasil terhubung ke port: " + portName);
  } catch (Exception e) {
    println("ERROR: Gagal terhubung ke port. Periksa nomor 'portIndex' dan pastikan Arduino terhubung.");
    e.printStackTrace();
  }
}

void draw() {
  background(240); // Warna latar belakang abu-abu muda
  fill(50); // Warna teks
  textAlign(CENTER, CENTER);
  text("Jembatan Arduino ke Web Aktif.\nBiarkan jendela ini tetap terbuka.", width/2, height/2);
}

// Fungsi ini akan otomatis berjalan setiap kali ada data baru dari Arduino
void serialEvent(Serial p) {
  // Baca data string sampai ada karakter baris baru ('\n')
  String dataFromArduino = p.readStringUntil('\n');
  
  // Jika data tidak kosong
  if (dataFromArduino != null) {
    // Hapus spasi atau karakter tak terlihat di awal/akhir
    dataFromArduino = trim(dataFromArduino);
    
    println("\nData diterima dari Arduino: '" + dataFromArduino + "'");
    
    // Jika data yang diterima sesuai, kirim ke server
    if (dataFromArduino.equals("Logam Terdeteksi")) {
      kirimKeServer(dataFromArduino);
    }
  }
}

void kirimKeServer(String statusDeteksi) {
  println("Mempersiapkan data untuk dikirim ke server...");
  
  // Membuat objek POST request baru
  PostRequest post = new PostRequest(apiUrl);
  
  // [PERBAIKAN] Mengatur header secara eksplisit
  post.addHeader("Content-Type", "application/x-www-form-urlencoded");
  post.addHeader("User-Agent", "Processing/3.x"); // Menambahkan User-Agent standar
  
  // Menggunakan metode addData() yang sudah terbukti bisa dikompilasi
  post.addData("status", statusDeteksi);
  
  // Mengirim request
  post.send();
  
  println("Data terkirim. Respons dari server:");
  // Menonaktifkan baris yang error untuk sementara.
  // Kita bisa cek keberhasilan dari konten yang diterima.
  // println("Status Code: " + post.code()); 
  println("Konten: " + post.getContent());
}
