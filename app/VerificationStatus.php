<?php

namespace App;

enum VerificationStatus: string
{
    case WAITING = "waiting";
    case IN_REVIEW = "in-review";
    case APPROVED = "approved";
    case REJECTED = "rejected";
    
}
