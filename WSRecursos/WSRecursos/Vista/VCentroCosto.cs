using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VCentroCosto : BDconexion
    {
        public List<ECentroCosto> Listar_CentroCosto()
        {
            List<ECentroCosto> lCCentroCosto = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CCentroCosto oVCentroCosto = new CCentroCosto();
                    lCCentroCosto = oVCentroCosto.Listar_CentroCosto(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCCentroCosto);
        }
    }
}