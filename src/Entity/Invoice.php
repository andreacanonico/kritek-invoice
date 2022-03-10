<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'integer')]
    private $number;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceBody::class)]
    private $invoiceBodies;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'invoices')]
    private $customer;

    public function __construct()
    {
        $this->invoiceBodies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceBody>
     */
    public function getInvoiceBodies(): Collection
    {
        return $this->invoiceBodies;
    }

    public function addInvoiceBody(InvoiceBody $invoiceBody): self
    {
        if (!$this->invoiceBodies->contains($invoiceBody)) {
            $this->invoiceBodies[] = $invoiceBody;
            $invoiceBody->setInvoiceId($this);
        }

        return $this;
    }

    public function removeInvoiceBody(InvoiceBody $invoiceBody): self
    {
        if ($this->invoiceBodies->removeElement($invoiceBody)) {
            // set the owning side to null (unless already changed)
            if ($invoiceBody->getInvoiceId() === $this) {
                $invoiceBody->setInvoiceId(null);
            }
        }

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

}
