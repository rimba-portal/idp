<?php

declare(strict_types=1);

namespace Rimba\Idp\Enums;

enum ClientApplicationType: string
{
    case ConfidentialWeb = 'confidential_web';
    case PublicPkce = 'public_pkce';
    case Service = 'service';
    case Device = 'device';
}

enum ClientTrustLevel: string
{
    case Standard = 'standard';
    case Trusted = 'trusted';
    case Restricted = 'restricted';
}

enum ClientStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Suspended = 'suspended';
    case Revoked = 'revoked';
}
