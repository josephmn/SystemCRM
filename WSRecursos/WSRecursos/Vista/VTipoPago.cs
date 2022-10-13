using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VTipoPago : BDconexion
    {
        public List<ETipoPago> TipoPago()
        {
            List<ETipoPago> lCTipoPago = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CTipoPago oVTipoPago = new CTipoPago();
                    lCTipoPago = oVTipoPago.Listar_TipoPago(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCTipoPago);
        }
    }
}