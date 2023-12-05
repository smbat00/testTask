<?php

class User {
    private int $id;
    private string $name;
    private float $balance;
    private array $transactions;

    public function __construct(int $id, string $name, float $balance = 0) {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
        $this->transactions = [];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getBalance(): float {
        return $this->balance;
    }

    public function getTransactions(): array {
        return $this->transactions;
    }

    public function deposit(float $amount): void {
        $this->balance += $amount;
        $this->addTransaction('Deposit', $amount);
    }

    public function withdraw(float $amount): void {
        if ($amount > $this->balance) {
            throw new Exception('Insufficient funds');
        }

        $this->balance -= $amount;
        $this->addTransaction('Withdrawal', $amount);
    }

    private function addTransaction(string $type, float $amount): void {
        $this->transactions[] = [
            'type' => $type,
            'amount' => $amount,
            'timestamp' => time(),
        ];
    }
}

class Transaction {
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function displayTransactions(): void {
        echo "Transactions for {$this->user->getName()} (ID: {$this->user->getId()}):\n";
        foreach ($this->user->getTransactions() as $transaction) {
            echo "{$transaction['type']} of {$transaction['amount']} at " . date('Y-m-d H:i:s', $transaction['timestamp']) . "\n";
        }
    }
}



$user1 = new User(1, 'John Doe');
$user1->deposit(100);
$user1->withdraw(50);

$transaction1 = new Transaction($user1);
$transaction1->displayTransactions();
