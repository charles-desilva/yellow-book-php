class Sale {
  constructor(
    saleDate,
    saleBy,
    invoiceNo,
    customerId,
    cashSale,
    chequeSale,
    creditSale
  ) {
    //console.log(this.invoiceNo);
    this.date = saleDate;
    this.by = saleBy;
    this.invoiceNum = invoiceNo;
    this.customer = customerId;
    this.cash = cashSale;
    this.cheque = chequeSale;
    this.credit = creditSale;
  }

  async saveSaleToDB() {
    let formData = new FormData();

    formData.append("saleDate", this.date);
    formData.append("saleBy", this.by);
    formData.append("invoiceNo", this.invoiceNum);
    formData.append("customerId", this.customer);
    formData.append("cashSale", this.cash);
    formData.append("chequeSale", this.cheque);
    formData.append("creditSale", this.credit);

    const res = await fetch("new_sale_action.php", {
      method: "POST",
      body: formData,
    });
    return res;
  }

  async updateSaleToDB(saleId) {
    let formData = new FormData();

    formData.append("saleId", saleId);
    formData.append("saleDate", this.date);
    formData.append("saleBy", this.by);
    formData.append("invoiceNo", this.invoiceNum);
    formData.append("customerId", this.customer);
    formData.append("cashSale", this.cash);
    formData.append("chequeSale", this.cheque);
    formData.append("creditSale", this.credit);

    const res = await fetch("update_sale_action.php", {
      method: "POST",
      body: formData,
    });
    return res;
  }

  static async deleteSaleFromDB(saleId) {
    let formData = new FormData();

    formData.append("saleId", saleId);

    const res = await fetch("delete_sale_action.php", {
      method: "POST",
      body: formData,
    });
    return res;
  }
}
