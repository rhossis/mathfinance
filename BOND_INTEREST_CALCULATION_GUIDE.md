# 📈 Guide to Accrued Interest Calculation for Bonds

This document provides a high-level technical reference for implementing bond accrued interest calculations in PHP. It supports a variety of day count conventions and handles both fixed and floating rate instruments, including those based on risk-free rates (RFRs).

---

## 📚 Contents

1. [Terminology](#terminology)
2. [Accrued Interest Calculation Steps](#accrued-interest-calculation-steps)
3. [Day Count Conventions](#day-count-conventions)
4. [Actual/Actual (ICMA) Method](#actualactual-icma-method)
5. [Floating Rate Notes Based on Risk-Free Rates](#floating-rate-notes-based-on-risk-free-rates)

---

## Terminology

- **Accrued Interest**: Interest accumulated from the last coupon payment to the settlement date.
- **Settlement Date**: The day a bond transaction is settled.
- **Coupon Frequency**: Number of coupon payments per year.
- **Jouissance**: First date of interest entitlement.
- **D1.M1.Y1**: Start date of interest period.
- **D2.M2.Y2**: End date (settlement or maturity).
- **D3.M3.Y3**: Next coupon payment date.

---

## Accrued Interest Calculation Steps

1. **Determine Settlement Date**  
   - Follows defined T+n cycles and skips currency holidays.

2. **Define Accrued Interest Dates**  
   - Based on coupon schedules and settlement date.

3. **Calculate Number of Interest-Bearing Days**  
   - Depends on the bond’s day count convention.

4. **Compute Accrued Interest**  
   - Uses formulas specific to the selected day count method.

---

## Day Count Conventions

| Method                 | Formula                                        |
|------------------------|------------------------------------------------|
| 30/360 (ISDA/ICMA)     | `A = C * (N / 360)`                            |
| Actual/360             | `A = C * (N / 360)`                            |
| Actual/365 (Fixed)     | `A = C * (N / 365)`                            |
| Actual/365L            | `A = C * (N / Y)` (Y = days in year)          |
| Actual/Actual (ICMA)   | `A = (C / F) * (N / C)` (regular coupons)     |
| Actual/364             | `A = (C * (N / 364)`                          |

---

## Actual/Actual (ICMA) Method

- Differentiates **regular** vs **irregular** periods.
- **Regular**: Periods that are clean multiples of coupon frequency.
- **Irregular**: Uses *notional coupon periods* to adjust calculations.
- In irregular cases, the formula:
  ```
  A = Σ [(CouponAmount / F) * (Ni / Ci)]
  ```
  where Ni = days in notional period i, Ci = length of notional period i.

---

## Floating Rate Notes Based on Risk-Free Rates

With the shift from LIBOR to RFRs:
- Interest is calculated **in arrears**, not forward-looking.
- A **lookback period** defines how rates are compounded over time.
- Key components:
  - **Compounded rates** with optional **margin rate**.
  - **Modified Business Day Convention**.
  - **Rate flooring** to prevent negative interest.
  - **Custom lookback windows**.
  - **Rounded rates** based on ISDA standards.

---

## ✅ Key Features for Implementation

- Support for multiple day count methods.
- Handling of regular and irregular coupon schedules.
- Floating rate notes using backward-looking compounded RFRs.
- Modular architecture to accommodate bond-specific parameters.

---

## 🛠️ Recommended Use in PHP

Consider implementing the above logic as:
- `Bond` class with properties for coupon, frequency, dates.
- `InterestCalculator` class using strategy pattern for each day count convention.
- Separate module for RFR-based FRN calculations.
