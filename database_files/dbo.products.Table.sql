USE [BestClothing]
GO
/****** Object:  Table [dbo].[products]    Script Date: 4/27/2022 10:01:32 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[products](
	[prod_id] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[prod_itemid] [nchar](10) NULL,
	[prod_brand] [varchar](50) NULL,
	[prod_name] [varchar](250) NULL,
	[prod_price] [decimal](5, 2) NULL,
	[prod_img] [varchar](250) NULL,
	[featured] [char](1) NULL,
	[prod_category] [varchar](50) NULL,
 CONSTRAINT [PK_products] PRIMARY KEY CLUSTERED 
(
	[prod_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
