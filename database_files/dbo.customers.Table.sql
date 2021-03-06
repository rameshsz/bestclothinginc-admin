USE [BestClothing]
GO
/****** Object:  Table [dbo].[customers]    Script Date: 4/27/2022 10:01:32 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[customers](
	[customer_id] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[username] [varchar](50) NOT NULL,
	[password] [varchar](250) NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[last_name] [varchar](50) NOT NULL,
	[address] [varchar](50) NULL,
	[email] [varchar](50) NULL,
 CONSTRAINT [PK_customers] PRIMARY KEY CLUSTERED 
(
	[customer_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
