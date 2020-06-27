<?php

namespace rikudou\EuQrPayment\Sepa;

/**
 * @see https://www.iso20022.org/sites/default/files/2020-05/ExternalCodeSets_2Q2020_May2020_v1.xls
 */
class Purpose
{
    // Bank Debt
    public const BANK_LOAN_DELAYED_DRAW_FUNDING = 'BKDF';
    public const BANK_LOAN_FEES = 'BKFE';
    public const BANK_LOAN_FUNDING_MEMO = 'BKFM';
    public const BANK_LOAN_ACCRUED_INTEREST_PAYMENT = 'BKIP';
    public const BANK_LOAN_PRINCIPAL_PAYDOWN = 'BKPP';

    // Card Settlement
    public const CARD_BULK_CLEARING = 'CBLK';
    public const CARD_PAYMENT_WITH_CASH_BACK = 'CDCB';
    public const CASH_DISBURSEMENT_CASH_SETTLEMENT = 'CDCD';
    public const CASH_DISBURSEMENT_WITH_SURCHARGING = 'CDCS';
    public const CARD_DEFERRED_PAYMENT = 'CDDP';
    public const ORIGINAL_CREDIT = 'CDOC';
    public const QUASI_CASH = 'CDQC';
    public const E_PURSE_TOP_UP = 'ETUP';
    public const FEE_COLLECTION = 'FCOL';
    public const MOBILE_TOP_UP = 'MTUP';

    // Cash Mgmt
    public const ACCOUNT_MANAGEMENT = 'ACCT';
    public const CASH_MANAGEMENT_TRANSFER = 'CASH';
    public const COLLECTION_PAYMENT = 'COLL';
    public const CASH_DISBURSEMENT_CASH_MANAGEMENT = 'CSDB';
    public const DEPOSIT = 'DEPT';
    public const INTRA_COMPANY_PAYMENT = 'INTC';
    public const LIQUIDITY_MANAGEMENT = 'LIMA';
    public const NETTING = 'NETT';

    // Collateral
    public const BOND_FORWARD = 'BFWD';
    public const CROSS_CURRENCY_IRS = 'CCIR';
    public const CCP_CLEARED_INITIAL_MARGIN = 'CCPC';
    public const CCP_CLEARED_VARIATION_MARGIN = 'CCPM';
    public const CCP_CLEARED_INITIAL_MARGIN_SEGREGATED_CASH = 'CCSM';
    public const CREDIT_DEFAULT_SWAP = 'CRDS';
    public const CROSS_PRODUCT = 'CRPR';
    public const CREDIT_SUPPORT = 'CRSP';
    public const CREDIT_LINE = 'CRTL';
    public const EQUITY_OPTION = 'EQPT';
    public const EQUITY_SWAP = 'EQUS';
    public const EXOTIC_OPTION = 'EXPT';
    public const EXCHANGE_TRADED_DERIVATIVES = 'EXTD';
    public const FIXED_INCOME = 'FIXI';
    public const FORWARD_BROKER_OWNED_CASH_COLLATERAL = 'FWBC';
    public const FORWARD_CLIENT_OWNED_CASH_COLLATERAL = 'FWCC';
    public const FORWARD_BROKER_OWNED_CASH_COLLATERAL_SEGREGATED = 'FWSB';
    public const FORWARD_CLIENT_OWNED_SEGREGATED_CASH_COLLATERAL = 'FWSC';
    public const DAILY_MARGIN_ON_LISTED_DERIVATIVES = 'MARG';
    public const MBS_BROKER_OWNED_CASH_COLLATERAL = 'MBSB';
    public const MBS_CLIENT_OWNED_CASH_COLLATERAL = 'MBSC';
    public const FUTURES_INITIAL_MARGIN = 'MGCC';
    public const FUTURES_INITIAL_MARGIN_CLIENT_OWNED_SEGREGATED_CASH_COLLATERAL = 'MGSC';
    public const CLIENT_OWNED_OCC_PLEDGED_COLLATERAL = 'OCCC';
    public const OTC_OPTION_BROKER_OWNED_CASH_COLLATERAL = 'OPBC';
    public const OTC_OPTION_CLIENT_OWNED_CASH_COLLATERAL = 'OPCC';
    public const OTC_OPTION_BROKER_OWNED_SEGREGATED_CASH_COLLATERAL = 'OPSB';
    public const OTC_OPTION_CLIENT_OWNED_CASH_SEGREGATED_CASH_COLLATERAL = 'OPSC';
    public const FX_OPTION = 'OPTN';
    public const OTC_DERIVATIVES = 'OTCD';
    public const REPURCHASE_AGREEMENT = 'REPO';
    public const BILATERAL_REPO_BROKER_OWNED_COLLATERAL = 'RPBC';
    public const REPO_CLIENT_OWNED_COLLATERAL = 'RPCC';
    public const BILATERAL_REPO_BROKER_OWNED_SEGREGATED_CASH_COLLATERAL = 'RPSB';
    public const BILATERAL_REPO_CLIENT_OWNED_SEGREGATED_CASH_COLLATERAL = 'RPSC';
    public const REVERSE_REPURCHASE_AGREEMENT = 'RVPO';
    public const SECURITIES_BUY_SELL_SELL_BUY_BACK = 'SBSC';
    public const SINGLE_CURRENCY_IRS_EXOTIC = 'SCIE';
    public const SINGLE_CURRENCY_IRS = 'SCIR';
    public const SECURITIES_CROSS_PRODUCTS = 'SCRP';
    public const BROKER_OWNED_COLLATERAL_SHORT_SALE = 'SHBC';
    public const CLIENT_OWNED_COLLATERAL_SHORT_SALE = 'SHCC';
    public const SHORT_SELL = 'SHSL';
    public const SECURITIES_LENDING_AND_BORROWING = 'SLEB';
    public const SECURED_LOAN = 'SLOA';
    public const SWAP_BROKER_OWNED_CASH_COLLATERAL = 'SWBC';
    public const SWAP_CLIENT_OWNED_CASH_COLLATERAL = 'SWCC';
    public const SWAPTION = 'SWPT';
    public const SWAPS_BROKER_OWNED_SEGREGATED_CASH_COLLATERAL = 'SWSB';
    public const SWAPS_CLIENT_OWNED_SEGREGATED_CASH_COLLATERAL = 'SWSC';
    public const TO_BE_ANNOUNCED = 'TBAS';
    public const TBA_BROKER_OWNED_CASH_COLLATERAL = 'TBBC';
    public const TBA_CLIENT_OWNED_CASH_COLLATERAL = 'TBCC';
    public const TREASURY_CROSS_PRODUCT = 'TRCP';

    // Commercial
    public const AGRICULTURAL_TRANSFER = 'AGRT';
    public const ACCOUNTS_RECEIVABLES_ENTRY = 'AREN';
    public const BUSINESS_EXPENSES = 'BEXP';
    public const BACK_OFFICE_CONVERSION_ENTRY = 'BOCE';
    public const COMMERCIAL_PAYMENT = 'COMC';
    public const COPYRIGHT = 'CPYR';
    public const PURCHASE_SALE_OF_GOODS = 'GDDS';
    public const PURCHASE_SALE_OF_GOODS_AND_SERVICES = 'GDSV';
    public const PURCHASE_SALE_OF_GOODS_AND_SERVICES_WITH_CASH_BACK = 'GSCB';
    public const LICENSE_FEE = 'LICF';
    public const MOBILE_P_B_PAYMENT = 'MP2B';
    public const POINT_OF_PURCHASE_ENTRY = 'POPE';
    public const ROYALTIES = 'ROYA';
    public const PURCHASE_SALE_OF_SERVICES = 'SCVE';
    public const SERVICE_CHARGES = 'SERV';
    public const SUBSCRIPTION = 'SUBS';
    public const SUPPLIER_PAYMENT = 'SUPP';
    public const COMMERCIAL = 'TRAD';

    // Consumer
    public const CHARITY_PAYMENT = 'CHAR';
    public const CONSUMER_THIRD_PARTY_CONSOLIDATED_PAYMENT = 'COMT';
    public const MOBILE_P_P_PAYMENT = 'MP2P';

    // E-Commerce
    public const GUARANTEED_EPAYMENT = 'ECPG';
    public const EPAYMENT_RETURN = 'ECPR';
    public const NON_GUARANTEED_EPAYMENT = 'ECPU';
    public const EPAYMENT = 'EPAY';

    // Finance
    public const CAR_LOAN_PRINCIPAL_REPAYMENT = 'CLPR';
    public const COMPENSATION_PAYMENT = 'COMP';
    public const DEBIT_COLLECTION_PAYMENT = 'DBTC';
    public const GOVERNMENT_INSURANCE = 'GOVI';
    public const HOUSING_LOAN_REPAYMENT = 'HLRP';
    public const HOME_LOAN_SETTLEMENT = 'HLST';
    public const INSURANCE_PREMIUM_CAR = 'INPC';
    public const INSURANCE_PREMIUM_REFUND = 'INPR';
    public const PAYMENT_OF_INSURANCE_CLAIM = 'INSC';
    public const INSURANCE_PREMIUM = 'INSU';
    public const INTEREST = 'INTE';
    public const LABOR_INSURANCE = 'LBRI';
    public const LIFE_INSURANCE = 'LIFI';
    public const LOAN = 'LOAN';
    public const LOAN_REPAYMENT = 'LOAR';
    public const PAYMENT_BASED_ON_ENFORCEMENT_ORDER = 'PENO';
    public const PROPERTY_INSURANCE = 'PPTI';
    public const RENTAL_LEASE_GENERAL = 'RELG';
    public const RECURRING_INSTALLMENT_PAYMENT = 'RINP';
    public const TRUST_FUND = 'TRFD';

    // Foreign Exchange
    public const FORWARD_FOREIGN_EXCHANGE = 'FORW';
    public const FOREIGN_EXCHANGE_RELATED_NETTING = 'FXNT';

    // General
    public const ADMINISTRATIVE_MANAGEMENT = 'ADMG';
    public const ADVANCE_PAYMENT = 'ADVA';
    public const BEARER_CHEQUE_DOMESTIC = 'BCDM';
    public const BEARER_CHEQUE_FOREIGN = 'BCFG';
    public const BUILDING_MAINTENANCE = 'BLDM';
    public const BOND_FORWARD_NETTING = 'BNET';
    public const CAPITAL_BUILDING = 'CBFF';
    public const CAPITAL_BUILDING_RETIREMENT = 'CBFR';
    public const CREDIT_CARD_PAYMENT = 'CCRD';
    public const CREDIT_CARD_BILL = 'CDBL';
    public const CANCELLATION_FEE = 'CFEE';
    public const CARD_GENERATED_DIRECT_DEBIT = 'CGDD';
    public const TRADE_SETTLEMENT_PAYMENT = 'CORT';
    public const COSTS = 'COST';
    public const CARPARK_CHARGES = 'CPKC';
    public const DEBIT_CARD_PAYMENT = 'DCRD';
    public const PRINTED_ORDER_DISBURSEMENT = 'DSMT';
    public const DELIVER_AGAINST_PAYMENT = 'DVPM';
    public const EDUCATION = 'EDUC';
    public const FACTOR_UPDATE_RELATED_PAYMENT = 'FACT';
    public const FINANCIAL_AID_IN_CASE_OF_NATURAL_DISASTER = 'FAND';
    public const LATE_PAYMENT_OF_FEES_CHARGES = 'FCPM';
    public const PAYMENT_OF_FEES = 'FEES';
    public const GOVERNMENT_PAYMENT = 'GOVT';
    public const IRREVOCABLE_CREDIT_CARD_PAYMENT = 'ICCP';
    public const IRREVOCABLE_DEBIT_CARD_PAYMENT = 'IDCP';
    public const INSTALMENT_HIRE_PURCHASE_AGREEMENT = 'IHRP';
    public const INSTALLMENT = 'INSM';
    public const INVOICE_PAYMENT = 'IVPT';
    public const MULTI_CURRENY_CHEQUE_DOMESTIC = 'MCDM';
    public const MULTI_CURRENY_CHEQUE_FOREIGN = 'MCFG';
    public const MULTIPLE_SERVICE_TYPES = 'MSVC';
    public const NOT_OTHERWISE_SPECIFIED = 'NOWS';
    public const ORDER_CHEQUE_DOMESTIC = 'OCDM';
    public const ORDER_CHEQUE_FOREIGN = 'OCFG';
    public const OPENING_FEE = 'OFEE';
    public const OTHER = 'OTHR';
    public const PREAUTHORIZED_DEBIT = 'PADD';
    public const PAYMENT_TERMS = 'PTSP';
    public const REPRESENTED_CHECK_ENTRY = 'RCKE';
    public const RECEIPT_PAYMENT = 'RCPT';
    public const REBATE = 'REBT';
    public const REFUND = 'REFU';
    public const RENT = 'RENT';
    public const ACCOUNT_OVERDRAFT_REPAYMENT = 'REOD';
    public const REIMBURSEMENT_OF_A_PREVIOUS_ERRONEOUS_TRANSACTION = 'RIMB';
    public const BILATERAL_REPO_INTERNET_NETTING = 'RPNT';
    public const ROUND_ROBIN = 'RRBN';
    public const REIMBURSEMENT_RECEIVED_CREDIT_TRANSFER = 'RRCT';
    public const RECEIVE_AGAINST_PAYMENT = 'RVPM';
    public const PAYMENT_SLIP_INSTRUCTION = 'SLPI';
    public const SPLIT_PAYMENTS = 'SPLT';
    public const STUDY = 'STDY';
    public const TBA_PAIROFF_NETTING = 'TBAN';
    public const TELECOMMUNICATIONS_BILL = 'TBIL';
    public const TOWN_COUNCIL_SERVICE_CHARGES = 'TCSC';
    public const TELEPHONE_INITIATED_TRANSACTION = 'TELI';
    public const TMPG_CLAIM_PAYMENT = 'TMPG';
    public const TRI_PARTY_REPO_INTEREST = 'TPRI';
    public const TRIPARTY_REPO_NETTING = 'TPRP';
    public const TRUNCATED_PAYMENT_SLIP = 'TRNC';
    public const TRAVELLER_CHEQUE = 'TRVC';
    public const INTERNET_INITIATED_TRANSACTION = 'WEBI';

    // Instant Payments
    public const INSTANT_PAYMENTS = 'IPAY';
    public const INSTANT_PAYMENTS_CANCELLATION = 'IPCA';
    public const INSTANT_PAYMENTS_FOR_DONATIONS = 'IPDO';
    public const INSTANT_PAYMENTS_IN_E_COMMERCE_WITHOUT_ADDRESS_DATA = 'IPEA';
    public const INSTANT_PAYMENTS_IN_E_COMMERCE_WITH_ADDRESS_DATA = 'IPEC';
    public const INSTANT_PAYMENTS_IN_E_COMMERCE = 'IPEW';
    public const INSTANT_PAYMENTS_AT_POS = 'IPPS';
    public const INSTANT_PAYMENTS_RETURN = 'IPRT';
    public const INSTANT_PAYMENTS_UNATTENDED_VENDING_MACHINE_WITH_FA = 'IPU2';
    public const INSTANT_PAYMENTS_UNATTENDED_VENDING_MACHINE_WITHOUT_FA = 'IPUW';

    // Investment
    public const ANNUITY = 'ANNI';
    public const CUSTODIAN_MANAGEMENT_FEE_INHOUSE = 'CAFI';
    public const CAPITAL_FALLING_DUE_INHOUSE = 'CFDI';
    public const COMMODITY_TRANSFER = 'CMDT';
    public const DERIVATIVES = 'DERI';
    public const DIVIDEND = 'DIVD';
    public const FOREIGN_EXCHANGE = 'FREX';
    public const HEDGING = 'HEDG';
    public const INVESTMENT_SECURITIES = 'INVS';
    public const PRECIOUS_METAL = 'PRME';
    public const SAVINGS = 'SAVG';
    public const SECURITIES = 'SECU';
    public const SECURITIES_PURCHASE_INHOUSE = 'SEPI';
    public const TREASURY_PAYMENT = 'TREA';
    public const UNIT_TRUST_PURCHASE = 'UNIT';

    // Listed Derivatives
    public const FUTURES_NETTING_PAYMENT = 'FNET';
    public const FUTURES = 'FUTR';

    // Medical
    public const ANESTHESIA_SERVICES = 'ANTS';
    public const CONVALESCENT_CARE_FACILITY = 'CVCF';
    public const DURABLE_MEDICALE_EQUIPMENT = 'DMEQ';
    public const DENTAL_SERVICES = 'DNTS';
    public const HOME_HEALTH_CARE = 'HLTC';
    public const HEALTH_INSURANCE = 'HLTI';
    public const HOSPITAL_CARE = 'HSPC';
    public const INTERMEDIATE_CARE_FACILITY = 'ICRF';
    public const LONG_TERM_CARE_FACILITY = 'LTCF';
    public const MEDICAL_AID_FUND_CONTRIBUTION = 'MAFC';
    public const MEDICAL_AID_REFUND = 'MARF';
    public const MEDICAL_SERVICES = 'MDCS';
    public const VISION_CARE = 'VIEW';

    // OTC Derivatives
    public const CREDIT_DEFAULT_EVENT_PAYMENT = 'CDEP';
    public const SWAP_CONTRACT_FINAL_PAYMENT = 'SWFP';
    public const SWAP_CONTRACT_PARTIAL_PAYMENT = 'SWPP';
    public const SWAP_CONTRACT_RESET_PAYMENT = 'SWRS';
    public const SWAP_CONTRACT_UPFRONT_PAYMENT = 'SWUF';

    // Salary & Benefits
    public const ADVISORY_DONATION_COPYRIGHT_SERVICES = 'ADCS';
    public const ACTIVE_EMPLOYMENT_POLICY = 'AEMP';
    public const ALLOWANCE = 'ALLW';
    public const ALIMONY_PAYMENT = 'ALMY';
    public const BABY_BONUS_SCHEME = 'BBSC';
    public const CHILD_BENEFIT = 'BECH';
    public const UNEMPLOYMENT_DISABILITY_BENEFIT = 'BENE';
    public const BONUS_PAYMENT = 'BONU';
    public const CASH_COMPENSATION_HELPLESSNESS_DISABILITY = 'CCHD';
    public const COMMISSION = 'COMM';
    public const COMPANY_SOCIAL_LOAN_PAYMENT_TO_BANK = 'CSLP';
    public const GUARANTEE_FUND_RIGHTS_PAYMENT = 'GFRP';
    public const AUSTRIAN_GOVERNMENT_EMPLOYEES_CATEGORY_A = 'GVEA';
    public const AUSTRIAN_GOVERNMENT_EMPLOYEES_CATEGORY_B = 'GVEB';
    public const AUSTRIAN_GOVERNMENT_EMPLOYEES_CATEGORY_C = 'GVEC';
    public const AUSTRIAN_GOVERNMENT_EMPLOYEES_CATEGORY_D = 'GVED';
    public const GOVERMENT_WAR_LEGISLATION_TRANSFER = 'GWLT';
    public const HOUSING_RELATED_CONTRIBUTION = 'HREC';
    public const PAYROLL = 'PAYR';
    public const PENSION_FUND_CONTRIBUTION = 'PEFC';
    public const PENSION_PAYMENT = 'PENS';
    public const PRICE_PAYMENT = 'PRCP';
    public const REHABILITATION_SUPPORT = 'RHBS';
    public const SALARY_PAYMENT = 'SALA';
    public const SALARY_PENSION_SUM_PAYMENT = 'SPSP';
    public const SOCIAL_SECURITY_BENEFIT = 'SSBE';

    // Securities Lending
    public const LENDING_BUY_IN_NETTING = 'LBIN';
    public const LENDING_CASH_COLLATERAL_FREE_MOVEMENT = 'LCOL';
    public const LENDING_FEES = 'LFEE';
    public const LENDING_EQUITY_MARKEDTOMARKET_CASH_COLLATERAL = 'LMEQ';
    public const LENDING_FIXED_INCOME_MARKEDTOMARKET_CASH_COLLATERAL = 'LMFI';
    public const LENDING_UNSPECIFIED_TYPE_OF_MARKEDTOMARKET_CASH_COLLATERAL = 'LMRK';
    public const LENDING_REBATE_PAYMENTS = 'LREB';
    public const LENDING_REVENUE_PAYMENTS = 'LREV';
    public const LENDING_CLAIM_PAYMENT = 'LSFL';

    // Tax
    public const ESTATE_TAX = 'ESTX';
    public const FOREIGN_WORKER_LEVY = 'FWLV';
    public const GOODS_SERVICES_TAX = 'GSTX';
    public const HOUSING_TAX = 'HSTX';
    public const INCOME_TAX = 'INTX';
    public const NET_INCOME_TAX = 'NITX';
    public const PROPERTY_TAX = 'PTXP';
    public const ROAD_TAX = 'RDTX';
    public const TAX_PAYMENT = 'TAXS';
    public const VALUE_ADDED_TAX_PAYMENT = 'VATX';
    public const WITH_HOLDING = 'WHLD';
    public const TAX_REFUND = 'TAXR';

    // Trailer Fee
    public const TRAILER_FEE_PAYMENT = 'B112';
    public const TRAILER_FEE_REBATE = 'BR12';
    public const NON_US_MUTUAL_FUND_TRAILER_FEE_PAYMENT = 'TLRF';
    public const NON_US_MUTUAL_FUND_TRAILER_FEE_REBATE_PAYMENT = 'TLRR';

    // Transport
    public const AIR = 'AIRB';
    public const BUS = 'BUSB';
    public const FERRY = 'FERB';
    public const RAILWAY = 'RLWY';
    public const ROAD_PRICING = 'TRPT';

    // Utilities
    public const CABLE_TVBILL = 'CBTV';
    public const ELECTRICITY_BILL = 'ELEC';
    public const ENERGIES = 'ENRG';
    public const GAS_BILL = 'GASB';
    public const NETWORK_CHARGE = 'NWCH';
    public const NETWORK_COMMUNICATION = 'NWCM';
    public const OTHER_TELECOM_RELATED_BILL = 'OTLC';
    public const TELEPHONE_BILL = 'PHON';
    public const UTILITIES = 'UBIL';
    public const WATER_BILL = 'WTER';
}
