<?php

namespace BCAParser\Tests;

use PHPUnit\Framework\TestCase;
use BCAParser\BCAParser;

class BCAParserTest extends TestCase
{
    private $username;
    private $password;

    private BCAParser $client;

    public function setUp(): void
    {
        $this->username = getenv("BCA_USERNAME");
        $this->password = getenv("BCA_PASSWORD");

        $this->client = new BCAParser($this->username, $this->password);
    }

    public function testGetBalance(): void
    {
        $balance = $this->client->getSaldo();
        $this->client->logout();

        $this->assertIsArray($balance);
        $this->assertGreaterThanOrEqual(1, count($balance));
        $tx = $balance[0];
        $this->assertArrayHasKey('rekening', $tx);
        $this->assertArrayHasKey('saldo', $tx);
    }

    public function testGetTransactionMutation(): void
    {
        $fromDate = date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 week'));
        $toDate = date('Y-m-d');

        $transactions = $this->client->getListTransaksi($fromDate, $toDate);
        $this->client->logout();

        $this->assertIsArray($transactions);
        if (count($transactions) > 0) {
            $this->assertGreaterThanOrEqual(1, count($transactions));
            $tx = array_values($transactions)[0];
            $this->assertArrayHasKey('date', $tx);
            $this->assertArrayHasKey('description', $tx);
        }
    }

    public function testGetTransactionDebit(): void
    {
        $fromDate = date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 week'));
        $toDate = date('Y-m-d');

        $transactions = $this->client->getTransaksiDebit($fromDate, $toDate);
        $this->client->logout();

        $this->assertIsArray($transactions);
        if (count($transactions) > 0) {
            $this->assertGreaterThanOrEqual(1, count($transactions));
            $tx = array_values($transactions)[0];
            $this->assertArrayHasKey('date', $tx);
            $this->assertArrayHasKey('description', $tx);
        }
    }

    public function testGetTransactionCredit(): void
    {
        $fromDate = date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 week'));
        $toDate = date('Y-m-d');

        $transactions = $this->client->getTransaksiCredit($fromDate, $toDate);
        $this->client->logout();

        $this->assertIsArray($transactions);
        if (count($transactions) > 0) {
            $this->assertGreaterThanOrEqual(1, count($transactions));
            $tx = array_values($transactions)[0];
            $this->assertArrayHasKey('date', $tx);
            $this->assertArrayHasKey('description', $tx);
        }
    }
}
