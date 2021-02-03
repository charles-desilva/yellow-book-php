class Credit {
  constructor(saleId, creditValue, creditDate, creditStatus = 0) {
    this.saleId = saleId;
    this.value = creditValue;
    this.creditDate = creditDate;
    this.status = creditStatus;
  }

  async saveCreditToDB() {
    let formData = new FormData();

    formData.append("saleId", this.saleId);
    formData.append("creditValue", this.value);
    formData.append("creditDate", this.creditDate);
    formData.append("chqStatus", this.status);

    const res = fetch("new_credit_action.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response)
      .then((data) => data);

    return res;
  }

  async updateCreditToDB() {
    let formData = new FormData();

    formData.append("saleId", this.saleId);
    formData.append("creditValue", this.value);
    formData.append("creditDate", this.creditDate);

    const res = fetch("update_credit_action.php", {
      method: "POST",
      body: formData,
    });

    return res;
  }

  static async deleteCreditBySaleId(saleId) {
    let formData = new FormData();

    formData.append("saleId", saleId);

    const res = await fetch("delete_cre_by_sale_action.php", {
      method: "POST",
      body: formData,
    });
    return res;
  }
}
