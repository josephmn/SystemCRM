using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VEntidadFinanciera : BDconexion
    {
        public List<EEntidadFinanciera> EntidadFinanciera()
        {
            List<EEntidadFinanciera> lCEntidadFinanciera = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CEntidadFinanciera oVEntidadFinanciera = new CEntidadFinanciera();
                    lCEntidadFinanciera = oVEntidadFinanciera.Listar_EntidadFinanciera(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEntidadFinanciera);
        }
    }
}