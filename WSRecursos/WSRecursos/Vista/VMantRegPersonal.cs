using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantRegPersonal : BDconexion
    {
        public List<EMantenimiento> MantRegPersonal(
                String pertipodoc, String perpaterno, String permaterno, String pernombre, String peremail,
                String peressalud, String perdomic, String perrefzona, String perdep, String perprov, String perdist,
                String perttrab, String perregimen, String pernivel, String perocup, String perdisc, String pertcon,
                String perjmax, String perafeps, String perexqta, String pertpago, String perafp, String perarea,
                String perbanco, String perbancocts, String perbruto, String percargo, String percond, String perctaban,
                String perdir, String perid, String peremp, String perfing, String perfnac, Int32 perhijos,
                String permovilidad, String pernac, String pernumafp, String perruc, String perruta, String perseguro,
                String persub, String persubarea, String persexo, String pertipopago, String pertlf1, String perzonaid,
                String user10, String user2, String user4, String user5, String user6, String MontoQuintaExt, String MontoRetenidoQuinta,
                String movilidadAdmin, String periodosueldo, String periodoqta, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantRegPersonal oVMantRegPersonal = new CMantRegPersonal();
                    lCEMantenimiento = oVMantRegPersonal.MantRegPersonal(con, pertipodoc, perpaterno, permaterno, pernombre, peremail, peressalud,
                    perdomic, perrefzona, perdep, perprov, perdist, perttrab, perregimen,
                    pernivel, perocup, perdisc, pertcon, perjmax, perafeps, perexqta,
                    pertpago, perafp, perarea, perbanco, perbancocts, perbruto, percargo,
                    percond, perctaban, perdir, perid, peremp, perfing, perfnac,
                    perhijos, permovilidad, pernac, pernumafp, perruc, perruta, perseguro,
                    persub, persubarea, persexo, pertipopago, pertlf1, perzonaid, user10,
                    user2, user4, user5, user6, MontoQuintaExt, MontoRetenidoQuinta, movilidadAdmin,
                    periodosueldo, periodoqta, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}