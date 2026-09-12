<?php

declare(strict_types=1);

namespace DesignPatterns\Structural\Adapter;

/**
 * EBookAdapter (o "Adapter" / Adaptador)
 *
 * Esta classe resolve o conflito de interfaces entre o cliente, que espera
 * um objeto do tipo Book (Target), e o subsistema externo Kindle, que
 * implementa EBook (Adaptee) com uma nomenclatura de métodos incompatível.
 *
 * A classe implementa Book para que o código cliente continue funcionando
 * sem nenhuma alteração, e usa COMPOSIÇÃO (injeção de dependência via
 * construtor) para guardar uma referência ao objeto EBook adaptado,
 * em vez de herdar dele. Cada método da interface Book é então "traduzido"
 * internamente para a chamada equivalente na interface EBook.
 */
class EBookAdapter implements Book
{
    /**
     * Composição: o adaptador não é um EBook, ele TEM um EBook.
     * A dependência é injetada via construtor (Dependency Injection).
     */
    public function __construct(protected EBook $eBook)
    {
    }

    /**
     * Tradução: Book::open() -> EBook::unlock()
     */
    public function open()
    {
        $this->eBook->unlock();
    }

    /**
     * Tradução: Book::turnPage() -> EBook::pressNext()
     */
    public function turnPage()
    {
        $this->eBook->pressNext();
    }

    /**
     * Tradução de tipo de retorno: EBook::getPage() devolve um array
     * [paginaAtual, totalDePaginas] (int[]), enquanto Book::getPage()
     * precisa devolver apenas um int (a página atual). O adaptador
     * extrai o primeiro elemento do array para cumprir o contrato de Book.
     */
    public function getPage(): int
    {
        return $this->eBook->getPage()[0];
    }
}