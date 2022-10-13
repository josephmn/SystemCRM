using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CEmpresa
    {
        public List<EEmpresa> Listar_Empresa(SqlConnection con)
        {
            List<EEmpresa> lEEmpresa = null;
            SqlCommand cmd = new SqlCommand("ASP_EMPRESA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEEmpresa = new List<EEmpresa>();

                EEmpresa obEEmpresa = null;
                while (drd.Read())
                {
                    obEEmpresa = new EEmpresa();
                    obEEmpresa.v_ruc = drd["v_ruc"].ToString();
                    obEEmpresa.v_razon = drd["v_razon"].ToString();
                    lEEmpresa.Add(obEEmpresa);
                }
                drd.Close();
            }

            return (lEEmpresa);
        }
    }
}