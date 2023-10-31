const main_list_digikey = 
        "2,670-1385-ND\n" +
        "2,670-1446-ND\n" +
        "2,609-5182-ND\n" +
        "2,296-38386-5-ND\n" +
        "8,296-8246-5-ND\n" +
        "1,296-32951-5-ND\n" +
        "2,296-2143-5-ND\n" +
        "13,296-4613-5-ND\n" +
        "1,296-14878-5-ND\n" +
        "6,296-1625-5-ND\n" +
        "2,296-12822-5-ND\n" +
        "1,296-33023-5-ND\n" +
        "11,296-8285-5-ND\n" +
        "6,296-12773-5-ND\n" +
        "8,296-12769-5-ND\n" +
        "4,296-12772-5-ND\n" +
        "2,296-2111-5-ND\n" +
        "3,296-4318-5-ND\n" +
        "1,296-2155-5-ND\n" +
        "3,296-9200-5-ND\n" +
        "1,2-5530843-7-ND\n" +
        "97,399-14010-1-ND\n" +
        "11,S3.3KHCT-ND\n" +
        "4,S150HCT-ND\n" +
        "4,732-8911-1-ND\n" +
        "2,296-8244-5-ND\n" +
        "1,296-12788-5-ND\n" +
        "1,296-26009-5-ND\n" +
        "1,296-25973-5-ND\n" +
        "1,296-1868-5-ND\n" +
        "1,CP-1403-ND\n" +
        "1,CP-1402-ND\n" +
        "14,S1KHCT-ND\n" +
        "1,S470HCT-ND\n" +
        "1,BC3919CT-ND\n" +
        "1,CF18JT16K0CT-ND\n" +
        "1,68KEBK-ND\n" +
        "1,445-180988-1-ND\n" +
        "1,399-14085-ND\n" +
        "1,399-4249-ND\n" +
        "1,399-14031-ND\n" +
        "1,2057-ICS-308-T-ND\n" +
        "33,2057-ICS-314-T-ND\n" +
        "34,AE9992-ND\n" +
        "17,2057-ICS-320-T-ND\n" +
        "1,ED3050-5-ND\n" +
        "4,296-25993-5-ND\n" +
        "1,296-1395-5-ND\n" +
        "1,EG2543-ND\n" +
        "1,EG4671-ND\n" +
        "1,1450-1027-ND\n" +
        "1,495-6805-1-ND\n" +
        "1,296-21834-5-ND\n" +
        "1,497-6610-1-ND\n" +
        "1,2092-KLDX-0202-AC-ND\n" +
        "1,732-8630-1-ND\n" +
        "1,732-8635-1-ND\n" +
        "1,2057-ICS-632-T-ND\n" +
        "1,S7039-ND\n" +
        "1,900-2177971022-ND\n" +
        "2,900-2177971021-ND\n" +
        "3,900-0022232021-ND\n" +
        "1,364-1263-ND\n";

const digikey_smds = "1,296-41661-1-ND\n";

const main_list_mouser = "955-W65C02S6TPG-14|2\n" +
    "955-W65C22N6TPG-14|1\n" +
    "437-5408805224008|1\n" +
    "437-5408806824008|1\n" +
    "913-AS6C62256-55PCN|1\n" +
    "571-1-2199299-5|3\n";

const mouser_smds = "575-9900015802227040|8\n" +
    "449-LFSPXO022134BULK|1\n";

const mouser_nosmds = "575-9900015802227040|4\n";


const mouser_dprams = "972-7007L15JG|1\n" +
    "972-7134LA20JG|1\n";

function update_order_lists() {
    const checkbox_smds = document.getElementById("order_exclude_smds").checked;
    const checkbox_dprams = document.getElementById("order_exclude_dprams").checked;
    const digikey_box = document.getElementById("digikey_order");
    const mouser_box = document.getElementById("mouser_order");

    digikey_box.value = 
        (checkbox_smds ? "" : digikey_smds) +
        main_list_digikey;
    mouser_box.value =
        (checkbox_smds ? mouser_nosmds : mouser_smds) +
        (checkbox_dprams ? "" : mouser_dprams) +
        main_list_mouser;
}

document.getElementById("order_exclude_smds").addEventListener("change", update_order_lists);
document.getElementById("order_exclude_dprams").addEventListener("change", update_order_lists);


update_order_lists();