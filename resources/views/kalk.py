import os

def clear_screen():
    os.system('cls' if os.name == 'nt' else 'clear')

def tambah(*args):
    return sum(args)

def kurang(*args):
    result = args[0]
    for num in args[1:]:
        result -= num
    return result

def kali(*args):
    result = 1
    for num in args:
        result *= num
    return result

def bagi(*args):
    result = args[0]
    try:
        for num in args[1:]:
            if num == 0:
                return "Error: Pembagian dengan nol!"
            result /= num
    except ZeroDivisionError:
        return "Error: Pembagian dengan nol!"
    return result

def kalkulator():
    while True:
        clear_screen()
        print("=" * 30)
        print("    KALKULATOR SEDERHANA    ")
        print("=" * 30)
        print("1. Tambah")
        print("2. Kurang")
        print("3. Kali")
        print("4. Bagi")
        print("5. Keluar")
        print("=" * 30)
        
        pilihan = input("Pilih operasi (1/2/3/4/5): ")
        
        if pilihan == '5':
            print("Terima kasih telah menggunakan kalkulator!")
            break
        
        if pilihan in ('1', '2', '3', '4'):
            try:
                jumlah_angka = int(input("Masukkan jumlah angka yang ingin dioperasikan: "))
                angka = [float(input(f"Masukkan angka ke-{i+1}: ")) for i in range(jumlah_angka)]
            except ValueError:
                print("Error: Masukkan angka yang valid!")
                input("Tekan Enter untuk melanjutkan...")
                continue
            
            if pilihan == '1':
                hasil = tambah(*angka)
            elif pilihan == '2':
                hasil = kurang(*angka)
            elif pilihan == '3':
                hasil = kali(*angka)
            elif pilihan == '4':
                hasil = bagi(*angka)
            
            print(f"\nHasil: {hasil}")
        else:
            print("Error: Pilihan tidak valid!")
        
        input("\nTekan Enter untuk melanjutkan...")

if __name__ == "__main__":
    kalkulator()