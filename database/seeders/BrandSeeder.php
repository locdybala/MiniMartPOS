<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Kinh Đô', 'image' => 'brands/UQ3uvaggEzxNwYhgrN21CE46Ghgje45vyO0qqQ2L.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Meizan', 'image' => 'brands/h0GNDMt23WLJc2LQSSSKmNrq9ce6eypcio5Tibei.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Custas', 'image' => 'brands/w6VFBHC07RNQfuftsQubAu0vHWByaDzWgqs2zi1F.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Bibica', 'image' => 'brands/YQGmk6JSe2hRFlhONSu6ge0IC6YBDXQF44krLMyb.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'URC', 'image' => 'brands/TiCVH57xDs1CmbNHhv1KiHjLxSVr321Yd5NX0EWf.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'PEPSICO', 'image' => 'brands/UWJxLN00fBmjB3BBL7Y89ihIA6klIiVTCLO71SGQ.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Coca‑Cola', 'image' => 'brands/axXaDzEfY444Wc6ne1HFy0M8nBUNWJSlTBDAGf0D.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Lavie', 'image' => 'brands/BkFAys2ZlNpwteQMaXsQjFsOP6Ly7IgvKXVda3o5.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Neptune', 'image' => 'brands/k5kW1EvPh1NFQdjYdNT6ijDCMFkhg2IhdOrPSGKb.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Hảo Hảo', 'image' => 'brands/r9l3bRzQErH1clvUN1hT84zqdSCiCcEZo2UO12nH.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => '3 miền', 'image' => 'brands/3y8PKwRCSvze6nhaZKDpbeCANsqK8Piuo0KpzHyV.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Omachi', 'image' => 'brands/mdJzDeEEQAsum4v0Hg4aWgoqWJWUZD2BGjeRyJj2.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Sunhouse', 'image' => 'brands/pP4KCvD35ziqISaLND2eQbt8Ud32O2lOafaHDNlF.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Kangaroo', 'image' => 'brands/edGKQgFDdutGpoHtwyK0Zjljhm3lECErGuSRMDsZ.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Unilever', 'image' => 'brands/O3KypLXCPGMtNpLAp3CQAwyLrL4K1a84K9O69K5h.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Công ty ICP', 'image' => 'brands/XEoJHUBGr573yBXKqHXwUWJlalzlbTvakxOjdta7.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Hoàng Gia', 'image' => 'brands/NJWavXc5TQiSzWZuGjGBvWvcnGW9oeOzv1hJN7kn.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Masan Consumer', 'image' => 'brands/oKqa3eOargkARkaxr4qb99Ml7uoWpd4C876I0Kl9.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Vinamilk', 'image' => 'brands/f4UUU4PwkGZHFhTRUKpmcGiMm9S1ts582U9hj2DU.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'NutiFood', 'image' => 'brands/GG8QgpMpDxfF6k68f4rA5nYRmOSs5FHHJy0q1ush.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'TH True milk', 'image' => 'brands/meX5EoVBbNA2rKFLhSX63X9NgJ1XPRPJtGz4aND4.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Nestlé', 'image' => 'brands/F3OkwBlflhFl8yn9cvjunAO4mSg2gfKuH8yTJxaX.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Trung Nguyên', 'image' => 'brands/1nlt9ECDcxdZbUWjHCyO5RFWzNldGi2bz0ARLCbc.png','description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Highlands coffee', 'image' => 'brands/gh8QAkNU23OvskSUZmdzYVBrH9cVwCA8TcHdiXd5.png','description' => null, 'status' => 1, 'created_by' => 1],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
