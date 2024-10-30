import http from 'k6/http';
import { check, sleep } from 'k6';

const BASE_URL = 'http://finance:9501';

export default function () {
    // Teste de depósito
    let depositPayload = JSON.stringify({
        account_number: "68c2c56d-8310-4628-b886-a82fccc289f5",
        transaction_type: "DEPOSIT",
        transaction_value: 100
    });

    let depositRes = http.post(`${BASE_URL}/transaction`, depositPayload, {
        headers: { 'Content-Type': 'application/json' }
    });

    check(depositRes, {
        'deposit status is 200': (r) => r.status === 200,
    });

    sleep(1); // Pausa de 1 segundo

    // Teste de saque
    let sakePayload = JSON.stringify({
        account_number: "68c2c56d-8310-4628-b886-a82fccc289f5",
        transaction_type: "SAKE",
        transaction_value: 100
    });

    let sakeRes = http.post(`${BASE_URL}/transaction`, sakePayload, {
        headers: { 'Content-Type': 'application/json' }
    });

    check(sakeRes, {
        'sake status is 200': (r) => r.status === 200,
    });

    sleep(1); // Pausa de 1 segundo

    // Teste de transferência
    let transferPayload = JSON.stringify({
        account_number_origin: "7557f6da-61f7-4e9c-8479-88aa52ed2050",
        account_number_destination: "68c2c56d-8310-4628-b886-a82fccc289f5",
        transaction_value: 100
    });

    let transferRes = http.post(`${BASE_URL}/transfer`, transferPayload, {
        headers: { 'Content-Type': 'application/json' }
    });

    check(transferRes, {
        'transfer status is 200': (r) => r.status === 200,
    });

    sleep(1); // Pausa de 1 segundo
}
