// กำหนดค่า EMA
input int emaPeriod1 = 50;
input int emaPeriod2 = 200;

// กำหนดค่าการเปิด Order
input double lotSize = 0.1; // ขนาด lot
input double takeProfitPercent = 0.01; // กำไรเป้าหมาย (%)
input double stopLossPercent = 0.01; // Stop Loss (%)

// ตัวแปรสำหรับเก็บค่า EMA
double emaCurrent1, emaPrevious1;
double emaCurrent2, emaPrevious2;

// ฟังก์ชั่น OnInit ทำงานครั้งเดียวทันทีที่ Expert Advisor ถูกเรียกใช้
int OnInit()
{
    // คำนวณ EMA ในระหว่าง Initializtion
    emaCurrent1 = iMA(NULL, 0, emaPeriod1, 0, MODE_EMA, PRICE_CLOSE, 0);
    emaPrevious1 = iMA(NULL, 0, emaPeriod1, 0, MODE_EMA, PRICE_CLOSE, 1);

    emaCurrent2 = iMA(NULL, 0, emaPeriod2, 0, MODE_EMA, PRICE_CLOSE, 0);
    emaPrevious2 = iMA(NULL, 0, emaPeriod2, 0, MODE_EMA, PRICE_CLOSE, 1);

    return(INIT_SUCCEEDED);
}

// ฟังก์ชั่น OnTick ทำงานทุกครั้งที่มีการเปลี่ยนแปลงราคา
void OnTick()
{
    // คำนวณ EMA ในทุก Tick
    emaCurrent1 = iMA(NULL, 0, emaPeriod1, 0, MODE_EMA, PRICE_CLOSE, 0);
    emaPrevious1 = iMA(NULL, 0, emaPeriod1, 0, MODE_EMA, PRICE_CLOSE, 1);

    emaCurrent2 = iMA(NULL, 0, emaPeriod2, 0, MODE_EMA, PRICE_CLOSE, 0);
    emaPrevious2 = iMA(NULL, 0, emaPeriod2, 0, MODE_EMA, PRICE_CLOSE, 1);

    // เปิด Order ตามเงื่อนไข
    if (emaCurrent1 > emaCurrent2 && emaPrevious1 <= emaPrevious2)
    {
        // เปิด Order Buy
        OrderSend(Symbol(), OP_BUY, lotSize, Ask, 3, 0, 0, "Buy Order", 0, 0, Green);
    }
    else if (emaCurrent1 < emaCurrent2 && emaPrevious1 >= emaPrevious2)
    {
        // เปิด Order Sell
        OrderSend(Symbol(), OP_SELL, lotSize, Bid, 3, 0, 0, "Sell Order", 0, 0, Red);
    }

    // ตรวจสอบทุกรายการ Order ที่เปิด
    for (int i = OrdersHistoryTotal() - 1; i >= 0; i--)
    {
        if (OrderSelect(i, SELECT_BY_POS, MODE_HISTORY))
        {
            // ตรวจสอบว่า Order เป็นของ Expert Advisor นี้หรือไม่
            if (OrderSymbol() == Symbol() && OrderMagicNumber() == 0) 
            {
                // ปรับปรุงกำหนดการ Close Order ด้วยกำไร 10% และ Stop Loss ที่ 30%
                double takeProfitLevel = OrderOpenPrice() + (OrderOpenPrice() * takeProfitPercent / 100);
                double stopLossLevel = OrderOpenPrice() - (OrderOpenPrice() * stopLossPercent / 100);

                // ปิด Order Buy ด้วยกำไรหรือ Stop Loss
                if (OrderType() == OP_BUY && Bid >= takeProfitLevel)
                {
                    OrderClose(OrderTicket(), OrderLots(), Bid, 3, Green);
                }
                else if (OrderType() == OP_BUY && Bid <= stopLossLevel)
                {
                    OrderClose(OrderTicket(), OrderLots(), Bid, 3, Red);
                }

                // ปิด Order Sell ด้วยกำไรหรือ Stop Loss
                if (OrderType() == OP_SELL && Ask <= takeProfitLevel)
                {
                    OrderClose(OrderTicket(), OrderLots(), Ask, 3, Green);
                }
                else if (OrderType() == OP_SELL && Ask >= stopLossLevel)
                {
                    OrderClose(OrderTicket(), OrderLots(), Ask, 3, Red);
                }
            }
        }
    }
}
