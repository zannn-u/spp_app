<?php
require_once __DIR__ . '/../../config/Database.php';

class PembayaranService {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function tambahPembayaran(int $idPetugas, string $nisn, string $tglBayar, string $bulan, string $tahun, int $idSpp, int $jumlah): void {
        $conn = $this->db->getConnection();
        $this->db->begin();
        try {
            // Cek unik
            $row = $this->db->queryOne(
                'SELECT COUNT(1) AS c FROM pembayaran WHERE nisn=? AND bulan_dibayar=? AND tahun_dibayar=?',
                'sss', [$nisn, $bulan, $tahun]
            );
            if ((int)($row['c'] ?? 0) > 0) {
                throw new RuntimeException('Pembayaran bulan-tahun sudah ada');
            }

            // Insert
            $this->db->exec(
                'INSERT INTO pembayaran (id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar) VALUES (?,?,?,?,?,?,?)',
                'issssii', [$idPetugas, $nisn, $tglBayar, $bulan, $tahun, $idSpp, $jumlah]
            );

            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}
?>

