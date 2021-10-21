<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CryptoMoneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crypto = [
            "AAVE" => "Aave",
            "ADA" => "Cardano",
            "ALGO" => "Algorand",
            "ANT" => "Aragon",
            "ATOM" => "Cosmos",
            "BAL" => "Balancer",
            "BAT" => "Basic Attention Token",
            "BCH" => "Bitcoin Cash",
            "COMP" => "Compound",
            "CRV" => "Curve",
            "DAI" => "Dai",
            "DASH" => "DASH",
            "DOT" => "DOT",
            "EOS" => "EOS",
            "FIL" => "Filecoin",
            "FLOW" => "Flow",
            "GNO" => "Gnosis",
            "GRT" => "The Graph",
            "ICX" => "ICON",
            "KAVA" => "Kava",
            "KEEP" => "Keep",
            "KNC" => "Kyber Network",
            "KSM" => "Kusama",
            "LINK" => "Chainlink",
            "LSK" => "Lisk",
            "MANA" => "Decentraland",
            "OMG" => "OmiseGO",
            "OXT" => "Orchid",
            "PAXG" => "PAX Gold",
            "QTUM" => "QTUM",
            "SC" => "Siacoin",
            "SNX" => "Synthetix",
            "STORJ" => "Storj",
            "TBTC" => "tBTC",
            "TRX" => "Tron",
            "UNI" => "Uniswap",
            "USDT" => "Tether",
            "WAVE" => "Waves",
            "XETC" => "Ethereum Classic",
            "XETH" => "Ethereum",
            "XLTC" => "Litecoin",
            "XMLN" => "Melon",
            "XREP" => "Augur",
            "XREPV2" => "Augur v2",
            "XXBT" => "Bitcoin",
            "XXDG" => "Dogecoin",
            "XXLM" => "Stellar Lumens",
            "XXMR" => "Monero",
            "XXRP" => "Ripple",
            "XXTZ" => "Tezos",
            "XZEC" => "Zcash",
            "YFI" => "Yearn Finance",
        ];

        foreach ($crypto as $key => $data) {
            DB::table('crypto_money')->insert([
                "name_crypto" => $data,
                "name_pair" => $key,
            ]);
        }
    }
}