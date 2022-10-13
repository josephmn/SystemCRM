using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConfiguracionCorreo : BDconexion
    {
        public List<EConfiguracionCorreo> ConfiguracionCorreo()
        {
            List<EConfiguracionCorreo> lCConfiguracionCorreo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConfiguracionCorreo oVConfiguracionCorreo = new CConfiguracionCorreo();
                    lCConfiguracionCorreo = oVConfiguracionCorreo.ConfiguracionCorreo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConfiguracionCorreo);
        }
    }
}