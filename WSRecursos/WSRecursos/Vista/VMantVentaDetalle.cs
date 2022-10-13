using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantVentaDetalle : BDconexion
    {
        public List<EMantenimiento> MantVentaDetalle(Int32 post, String pedido, String sku, String precio, String cantidad, String subtotal, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantVentaDetalle oVMantVentaDetalle = new CMantVentaDetalle();
                    lCEMantenimiento = oVMantVentaDetalle.MantVentaDetalle(con, post, pedido, sku, precio, cantidad, subtotal, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}