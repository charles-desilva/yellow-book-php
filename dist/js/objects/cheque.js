class Cheque {
  constructor(
    saleId,
    chqRcvdDate,
    chqNum,
    chqBnk,
    chqBranch,
    chqDate,
    chqValue,
    chqStatus = "in-hand",
    chqCreditId = null
  ) {
    this.saleId = saleId;
    this.chqRcvdDate = chqRcvdDate;
    this.number = chqNum;
    this.bank = chqBnk;
    this.branch = chqBranch;
    this.date = chqDate;
    this.value = chqValue;
    this.status = chqStatus;
    this.creditId = chqCreditId;
  }

  async saveChequeToDB() {
    let formData = new FormData();

    formData.append("saleId", this.saleId);
    formData.append("chqRcvdDate", this.chqRcvdDate);
    formData.append("chqNum", this.number);
    formData.append("bank", this.bank);
    formData.append("branch", this.branch);
    formData.append("chqDate", this.date);
    formData.append("chqValue", this.value);
    formData.append("chqStatus", this.status);
    formData.append("chqCreditId", this.creditId);
    formData.append("action", "insert");

    const res = fetch("new_cheque_action.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response)
      .then((data) => data);

    return res;
  }

  async updateChequeToDB() {
    let formData = new FormData();

    formData.append("saleId", this.saleId);
    formData.append("chqRcvdDate", this.chqRcvdDate);
    formData.append("chqNum", this.number);
    formData.append("bank", this.bank);
    formData.append("branch", this.branch);
    formData.append("chqDate", this.date);
    formData.append("chqValue", this.value);
    formData.append("chqStatus", this.status);
    formData.append("chqCreditId", this.creditId);

    const res = fetch("update_cheque_action.php", {
      method: "POST",
      body: formData,
    });
    return res;
  }

  static async deleteChequeBySaleId(saleId) {
    let formData = new FormData();

    formData.append("saleId", saleId);

    const res = await fetch("delete_chq_by_sale_action.php", {
      method: "POST",
      body: formData,
    });
    return res;
  }
}
